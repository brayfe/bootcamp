<?php
/**
 * @file
 * Enables theme/site configuration for the utexas profile site installation.
 */

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function utexas_form_install_configure_form_alter(&$form, $form_state) {
  // Pre-populate the site name with the server name.
  $form['site_information']['site_name']['#default_value'] = $_SERVER['SERVER_NAME'];
  // Pre-populate default country with US.
  $form['server_settings']['site_default_country']['#default_value'] = 'US';
  utexas_remove_message('was assigned to the invalid region', 'warning');
  utexas_remove_message('was assigned to the invalid');
  utexas_remove_message('configuration tasks');
  utexas_remove_message('Added new Google CSE Id variable');
  utexas_remove_message('Thank you for installing the Metatag module');
  utexas_remove_message('Tablesaw filter was enabled');
  utexas_remove_message('To use menu blocks');

  hide($form['update_notifications']);
  hide($form['server_settings']);
}

/**
 * Implements hook_install_tasks().
 *
 * Allows the profile to run specific tasks.
 */
function utexas_install_tasks(&$install_state) {
  // Add our custom CSS file for the installation process.
  drupal_add_css(drupal_get_path('profile', 'utexas') . '/utexas.css');
  $tasks = array(
    'utexas_configure' => array(),
    'utexas_default_page' => array(
      'display' => FALSE,
      'display_name' => st('Install default page content'),
      'type' => 'normal',
      'run' => INSTALL_TASK_RUN_IF_REACHED,
      'function' => 'install_utexas_preferences',
    ),
  );
  return $tasks;
}

/**
 * Set up base config.
 */
function utexas_configure() {

  // Run the Drupal Kit configuration tasks.
  variable_set('cache', 1);
  variable_set('block_cache', 1);
  variable_set('cache_lifetime', '0');
  variable_set('page_cache_maximum_age', '900');
  variable_set('page_compression', 0);
  variable_set('preprocess_css', 1);
  variable_set('preprocess_js', 1);
  $search_active_modules = array(
    'user' => 'user',
    'node' => 0,
  );
  variable_set('search_active_modules', $search_active_modules);

  // Enable clean URLs.
  variable_set('clean_url', 1);

}

/**
 * Implements hook_install_tasks_alter().
 *
 * Prefaces all other installation tasks with our new welcome screen.
 */
function utexas_install_tasks_alter(&$tasks, $install_state) {

  // The new "Welcome" screen/task needs to come after the first two steps
  // (profile and language selection), despite the fact that they are disabled.
  $new_task['install_utexas_welcome'] = array(
    'display' => TRUE,
    'display_name' => st('Welcome'),
    'type' => 'form',
    'run' => isset($install_state['parameters']['welcome']) ? INSTALL_TASK_SKIP : INSTALL_TASK_RUN_IF_REACHED,
    'function' => 'install_utexas_welcome',
  );
  $old_tasks = $tasks;
  $tasks = array_slice($old_tasks, 0, 1) + $new_task + array_slice($old_tasks, 1);
  return $tasks;
}

/**
 * Custom function for installation preferences.
 */
function install_utexas_preferences() {
  global $install_state;

  if ($install_state['parameters']['page_builder'] == 1) {
    install_utexas_page_builder();
  }

  elseif ($install_state['parameters']['default_page'] == 1) {
    include_once 'default_content/default_basic_page.inc';
    variable_set('site_frontpage', 'node/1');
  }

  if ($install_state['parameters']['default_menu'] == 1) {
    include_once 'default_content/default_menu.inc';
  }

  utexas_remove_message('clone', 'error');
  utexas_remove_message('context', 'error');

  // Ensure that the administrator account has all available permissions
  // except for Full HTML text format.
  $admin_role = user_role_load_by_name('administrator');
  user_role_grant_permissions($admin_role->rid, array_keys(module_invoke_all('permission')));
  user_role_revoke_permissions($admin_role->rid, array('use text format full_html'));

  // Reverting the features after enabling module.
  features_rebuild();
  features_revert();
  reorder_filtered_html_text_filters();
  cache_clear_all();
}

/**
 * Helper function to install Page Builder.
 */
function install_utexas_page_builder() {
  global $install_state;

  module_enable(array(
    'utexas_page_builder',
    'content_type_standard_page',
    'content_type_landing_page',
    )
  );
  // Reverting the features after enabling module.
  features_rebuild();
  features_revert();

  if ($install_state['parameters']['default_page'] == 1) {
    include_once 'default_content/default_standard_page.inc';
    include_once 'default_content/default_landing_page.inc';
    include_once 'default_content/default_video_filter_embed_page.inc';
    // Install default Qualtrics page if default content is enabled.
    if (module_exists('utexas_qualtrics_filter')) {
      $dir = drupal_get_path('module', 'utexas_qualtrics_filter');
      include_once $dir . '/assets/default_qualtrics_embed_page.inc';
      _utexas_qualtrics_filter_default_page();
    }
    variable_set('clone_menu_links', 0);
    variable_set('clone_method', 'save-edit');
    variable_set('clone_nodes_without_confirm', 1);
    variable_set('clone_omitted',
      array(
        'landing_page' => 0,
        'standard_page' => 0,
      )
    );
    variable_set('clone_reset_landing_page', 1);
    variable_set('clone_reset_standard_page', 1);
    variable_set('clone_use_node_type_name', 0);
    variable_set('site_frontpage', 'node/1');
  }
  cache_clear_all();
}

/**
 * Custom function for installation screen.
 */
function install_utexas_welcome($form, &$form_state, &$install_state) {
  // Set up the "Welcome" message.
  drupal_set_title(st('Welcome to the UT Drupal Kit'));
  $message = '<p>' . st('<strong>The goal of the UT Drupal Kit is to simplify deployment of University-affiliated websites while keeping all of the extensibility of Drupal\'s platform.</strong>') . '</p>';
  $message .= '<div class="messages warning">' . st('<h2>Special note for UT Web users</h2> <p>If you are installing the UT Drupal Kit on the UT Web service, please see the ' . l(t('Installation on UT Web'), 'https://wikis.utexas.edu/display/UTDK/Installation+on+UT+Web')) . ' documentation for important configuration guidelines.</p></div>';
  $message .= '<p>' . st('The Kit includes a custom login module which allows authentication via UTLogin, the centralized authentication service. This module requires configuration of a Web Policy Agent. For installation instructions, see ') . l(t('the UTLogin module documentation'), 'https://wikis.utexas.edu/display/UTDK/UTLogin+Module+Installation+and+Configuration') . '.</p>';
  $message .= '<p>' . st('For full documentation on installation and site building, visit the ' . l(t('UT Drupal Kit documentation'), 'https://wikis.utexas.edu/display/UTDK') . '. Contact the Drupal Kit support team at ' . l(t('drupal-kit-support@utlists.utexas.edu'), 'mailto:drupal-kit-support@utlists.utexas.edu') . '.');

  // The rest of the task (form).
  $form = array();
  $form['welcome_message'] = array(
    '#markup' => $message,
  );
  $form['actions'] = array(
    '#type' => 'actions',
  );
  $form['utexas_preferences'] = array(
    '#type' => 'fieldset',
    '#title' => t('Preferences'),
  );
  $form['utexas_preferences']['page_builder'] = array(
    '#type' => 'checkbox',
    '#default_value' => 1,
    '#title' => 'Enable drag-and-drop Page Builder and custom fields',
  );
  $form['utexas_preferences']['default_page'] = array(
    '#type' => 'checkbox',
    '#default_value' => 1,
    '#title' => 'Add sample page content',
  );
  $form['utexas_preferences']['default_menu'] = array(
    '#type' => 'checkbox',
    '#default_value' => 1,
    '#title' => 'Add sample menu content',
  );
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => st("Install the UT Drupal Kit!"),
    '#weight' => 10,
  );

  return $form;
}

/**
 * Implements hook_submit().
 *
 * Sends preference parameters for configuration tasks.
 */
function install_utexas_welcome_submit($form, &$form_state) {
  global $install_state;

  // Form submission.
  $install_state['parameters']['welcome'] = 'done';

  // Since we skipped the language selection (locale), need to set value here.
  $install_state['parameters']['locale'] = 'en';

  // The following if statements check to see if an argument has been passed via
  // drush site-install. If no arguments are present, the script proceeds,
  // taking either user input or defaulting to default_value in
  // install_utexas_welcome().
  $install_state['parameters']['page_builder'] = (!isset($install_state['forms']['utexas_preferences']['page_builder']))
    ? $form['utexas_preferences']['page_builder']['#value']
    : $install_state['forms']['utexas_preferences']['page_builder'];
  $install_state['parameters']['default_menu'] = (!isset($install_state['forms']['utexas_preferences']['default_menu']))
    ? $form['utexas_preferences']['default_menu']['#value']
    : $install_state['forms']['utexas_preferences']['default_menu'];
  $install_state['parameters']['default_page'] = (!isset($install_state['forms']['utexas_preferences']['default_page']))
    ? $form['utexas_preferences']['default_page']['#value']
    : $install_state['forms']['utexas_preferences']['default_page'];
}

/**
 * Remove a message as set by drupal_set_message().
 *
 * This is used during install to remove irrelevent messages.
 */
function utexas_remove_message($partial_message, $type = 'status') {
  if (!empty($_SESSION['messages'][$type])) {
    foreach ($_SESSION['messages'][$type] as $key => $message) {
      if (strpos($message, $partial_message) !== FALSE) {
        unset($_SESSION['messages'][$type][$key]);
      }
    }
    if (empty($_SESSION['messages'][$type])) {
      unset($_SESSION['messages'][$type]);
    }
  }
}
