<?php

/**
 * The URL to the external login action for UTLogin (handles form submissions).
 *
 * A conditional constant depending on the existence and value of the
 * utlogin_env variable.
 */
if (strtoupper(variable_get('utlogin_env', 'PROD')) == 'QUAL') {
  define('UTLOGIN_LOGIN_ACTION', 'https://utlogin-login-qual.its.utexas.edu/openam/UI/Login');
}
else {
  define('UTLOGIN_LOGIN_ACTION', 'https://login.utexas.edu/openam/UI/Login');
}

/**
 * The URL to the external login resource for UTLogin (presents form).
 *
 * A conditional constant depending on the existence and value of the
 * utlogin_env variable.
 */
if (strtoupper(variable_get('utlogin_env', 'PROD')) == 'QUAL') {
  define('UTLOGIN_LOGIN_URL', 'https://utlogin-login-qual.its.utexas.edu/login/UI/Login');
}
else {
  define('UTLOGIN_LOGIN_URL', 'https://login.utexas.edu/login/UI/Login');
}

class UtloginWebTestBase extends DrupalWebTestCase {

  protected $cookie_cache;
  protected $user1;
  protected $utlogin_users;
  protected $utlogin_users_file_path;

  /**
   * Sets up each test case independently.
   */
  public function setUp() {
    parent::setUp(array('utlogin'));

    $this->cookie_cache = array();
    $this->cookieFile = $this->public_files_directory . '/cookie.jar';
    $this->user1 = user_load(1, TRUE);
    $this->user1->pass_raw = NULL;

    $this->utlogin_users_file_path = DRUPAL_ROOT . '/' . drupal_get_path('module', 'utlogin') . '/tests/includes/utlogin_users.inc';
    $this->loadUtloginUsers();

    // Set the UTLogin login/logout block on the page, so assertions can be run
    // on its text.
    db_merge('block')
      ->key(array('theme' => 'bartik', 'delta' => 'utlogin_authentication', 'module' => 'utlogin'))
      ->fields(array(
        'region' => 'sidebar_first',
        'pages' => '',
        'status' => 1,
        'visibility' => BLOCK_VISIBILITY_NOTLISTED,
      ))
      ->execute();
  }

  /**
   * Ensures the user1 record has real data instead of the placeholder data.
   */
  protected function setUser1() {
    $edit = array();
    $edit['name'] = $this->randomName();
    $edit['mail'] = $edit['name'] . '@example.com';
    $edit['pass'] = user_password();
    $edit['status'] = 1;

    require_once DRUPAL_ROOT . '/' . variable_get('password_inc', 'includes/password.inc');
    db_merge('users')
      ->key(array('uid' => 1))
      ->fields(array(
        'name' => $edit['name'],
        'mail' => $edit['mail'],
        'pass' => user_hash_password(trim($edit['pass'])),
        'status' => $edit['status'],
      ))
      ->execute();

    $this->user1 = user_load(1, TRUE);
    $this->user1->pass_raw = $edit['pass'];

    return $this->user1;
  }

  /**
   * Attempts to load the UTLogin user data from an external include file.
   */
  protected function loadUtloginUsers() {
    if (file_exists($this->utlogin_users_file_path)) {
      global $conf;
      include $this->utlogin_users_file_path;
    }
    $this->utlogin_users = variable_get('utlogin_simpletest_utlogin_users', array());
  }

  /**
   * Saves cookies to a cache.
   *
   * This method is designed to be used as a custom callback for cURL requests.
   * Cookies in the response are saved to a cache.
   *
   * @see UtloginUserBase::getUtloginCookies()
   */
  protected function cacheResponseCookies($curlHandler, $header) {
    if (preg_match('/^Set-Cookie: ([^=]+)=(.+)/i', $header, $matches)) {
      $name = $matches[1];
      $parts = array_map('trim', explode(';', $matches[2]));
      $value = array_shift($parts);
      $this->cookie_cache[$name] = array('value' => $value, 'secure' => in_array('secure', $parts));
    }

    // This is required by cURL.
    return strlen($header);
  }

  /**
   * Authenticates a user with UTLogin servers and returns resulting cookies.
   *
   * Use a custom cURL request to authenticate with the UTLogin servers. If
   * successful, the response headers will contain a valid (authenticated)
   * UTLogin cookie.
   *
   * A custom header callback is used to parse the response headers and save any
   * cookies to a cache.
   *
   * @param string $eid
   *   The EID of the user with which a UTLogin authentication attempt will be
   *   made.
   *
   * @param string $password
   *   The password of the user with which a UTLogin authentication attempt will
   *   be made.
   *
   * @return array
   *   The cookies sent back in the response.
   *
   * @see UtloginUserBase::cacheResponseCookies()
   */
  protected function getUtloginCookies($eid, $password) {
    $curl_handle = curl_init();

    $url = UTLOGIN_LOGIN_ACTION;

    // Set up the necessary POST data for UTLogin authentication.
    $curl_post_fields = array(
      'IDToken1' => $eid,
      'IDToken2' => $password,
      'goto' => url('user/utlogin/login', array('absolute' => TRUE)),
    );

    $curl_options = array(
      CURLOPT_COOKIEJAR => NULL,
      CURLOPT_URL => $url,
      CURLOPT_FOLLOWLOCATION => FALSE,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_SSL_VERIFYPEER => FALSE,
      CURLOPT_SSL_VERIFYHOST => FALSE,
      CURLOPT_HEADERFUNCTION => array($this, 'cacheResponseCookies'),
      CURLOPT_POST => TRUE,
      CURLOPT_POSTFIELDS => http_build_query($curl_post_fields),
    );
    curl_setopt_array($curl_handle, $curl_options);

    // @todo Consider adding error handling based on returned content or code.
    $content = curl_exec($curl_handle);
    $http_code = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

    curl_close($curl_handle);

    $cookies = $this->cookie_cache;
    $this->cookie_cache = array();
    return $cookies;
  }

  /**
   * Returns an authenticated UTLogin user's UTLogin cookie value.
   *
   * If the UTLogin cookie is already in the user's cookie cache, return its
   * value, otherwise populate the cache and then return its value.
   *
   * @param array $utlogin_user
   *   An array of data specifying the UTLogin user.
   *
   * @param bool $connect
   *   If TRUE, try to populate the user's cookie cache when empty.
   *
   * @return string|null
   *   The UTLogin cookie's value if authentication was successful, NULL
   *   otherwise.
   *
   * @see UtloginUserBase::utloginLogin()
   */
  protected function getUtloginCookieValue(&$utlogin_user, $connect = TRUE) {
    if (array_key_exists(UTLOGIN_COOKIE_NAME, $utlogin_user['cookies']) && isset($utlogin_user['cookies'][UTLOGIN_COOKIE_NAME]['value'])) {
      return $utlogin_user['cookies'][UTLOGIN_COOKIE_NAME]['value'];
    }

    if ($connect) {
      $this->utloginLogin($utlogin_user);
    }
    if (!array_key_exists(UTLOGIN_COOKIE_NAME, $utlogin_user['cookies']) || empty($utlogin_user['cookies'][UTLOGIN_COOKIE_NAME])) {
      return NULL;
    }

    return $utlogin_user['cookies'][UTLOGIN_COOKIE_NAME]['value'];
  }

  /**
   * Authenticates a user with UTLogin.
   *
   * @param array $utlogin_user
   *   An array of data specifying the UTLogin user.
   *
   * @see UtloginUserBase::getUtloginCookies()
   */
  protected function utloginLogin(&$utlogin_user) {
    $utlogin_user['cookies'] = $this->getUtloginCookies($utlogin_user['name'], $utlogin_user['password']);
  }

  /**
   * De-authenticates a user with UTLogin.
   *
   * De-authenticate a UTLogin user by sending a cURL request to the UTLogin
   * logout resource with the user's UTLogin cookie.
   *
   * @param array $utlogin_user
   *   An array of data specifying the UTLogin user.
   */
  protected function utloginLogout($utlogin_user) {
    $curl_handle = curl_init();

    $url = UTLOGIN_LOGOUT_URL;
    $cookie = UTLOGIN_COOKIE_NAME . '=' . $this->getUtloginCookieValue($utlogin_user, FALSE);

    $curl_options = array(
      CURLOPT_COOKIEJAR => NULL,
      CURLOPT_URL => $url,
      CURLOPT_FOLLOWLOCATION => TRUE,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_SSL_VERIFYPEER => FALSE,
      CURLOPT_SSL_VERIFYHOST => FALSE,
      CURLOPT_COOKIE => $cookie,
    );
    curl_setopt_array($curl_handle, $curl_options);

    $content = curl_exec($curl_handle);
    $http_code = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

    curl_close($curl_handle);

    return $http_code;
  }
}
