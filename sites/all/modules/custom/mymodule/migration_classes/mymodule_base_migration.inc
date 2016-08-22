<?php
/**
 * @file
 * Code for the mymodule migration module.
 */

/**
 * Common mappings for migrations
 */
abstract class mymoduleBaseMigration extends Migration {

  /**
   * Demonstration of an arbitrary array to be used in multiple migrations.
   *
   * Call the variable via $this->source_base_url;
   */
  public $source_base_url = 'http://qual.moody.utexas.edu';

  /**
   * Demonstration of an arbitrary function to be used in multiple migrations.
   *
   * Call the array via $this->arbitrary_function($parameter);
   */
  public function arbitrary_function($parameter = NULL) {
    return $parameter;
  }

  /**
   * Provides the ability to alter the $row before saving.
   *
   * General purpose "tamper" of data that comes directly from a source row.
   * Also commonly use to "skip" rows that meet any criteria by returning FALSE.
   */
  public function prepareRow($row) {
    if (parent::prepareRow($row) === FALSE) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Provides the ability to alter the $node before saving.
   *
   * Useful if you do not have a source row to migrate from, e.g., you're
   * creating a taxonomy term based on a combination of other values.
   */
  public function prepare($node, stdClass $row) {
  }

  /**
   * Analogous to prepare(), but is called immediately after the complete
   * destination object is saved. Mainly used when you need the Drupal ID
   * of the newly-created object
   */
  public function complete($entity, stdClass $row) {
  }

  /**
   * Runs once, rather than as part of each row.
   * Executes before the first row has been imported.
   */
  public function preImport() {
    parent::preImport();
  }

  /**
   * Runs once, rather than as part of each row.
   * Executes after the last row has been imported.
   */
  public function postImport() {
    parent::postImport();
  }

  /**
   * Code to execute before the first row has been deleted.
   */
  public function preRollback() {
    parent::preRollback();
  }

  /**
   * Code to execute after the last article row has been deleted.
   */
  public function postRollback() {
    parent::postRollback();
  }

  /**
   * Custom function to prepare text, save inline images, & rewrite image URLs.
   */
  public function saveImagesInText($text) {
    // A variety of specialized str_replace functions to normalize Image URLs
    // To assume an absolute Base URL.
    $doc = new DOMDocument();
    @$doc->loadHTML(mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $tags = $doc->getElementsByTagName('img');

    foreach ($tags as $tag) {
      $image_url = $tag->getAttribute('src');
      // @todo: prep imageURL with an absolute path.
      $alt = $tag->getAttribute('alt');
      $title = $tag->getAttribute('title');
      $file = $this->fileAddImage($image_url, $alt, $title);
      $tag->setAttribute('src', $this->file_url_alter($file->uri));
    }
    // Return the textarea with absolute image URLs for more universality.
    $text = $doc->saveHTML();
    return $text;
  }

  /**
   * Provide proper URL with base path.
   */
  public function file_url_alter($uri) {
    global $base_path;

    $scheme = file_uri_scheme($uri);

    // If the file uses the public scheme...
    if ($scheme == 'public') {
      $wrapper = file_stream_wrapper_get_instance_by_scheme($scheme);
      // Get the file's path.
      $path = $wrapper->getDirectoryPath() . '/' . file_uri_target($uri);
      // Set the URL to the (relative) base path plus the file's path.
      return $base_path . $path;
    }
  }

  /**
   * Add new image file.
   */
  public function fileAddImage($image_url, $alt = NULL, $title = NULL, $filename = NULL, $tag = NULL) {
    $file = NULL;
    // Determine if the url is internal or external.
    $internal = TRUE;
    $image_url = str_replace(' ', '%20', $image_url);
    if (strpos(strtolower($image_url), 'moody.utexas.edu') === FALSE) {
      if (substr($image_url, 0, 2) == '//') {
        // This has the path of //something.com
        $internal = FALSE;
      }
      if (substr(strtolower($image_url), 0, 4) == 'http') {
        // This IS an absolute URL, therefore it must be external.
        $internal = FALSE;
      }
      if ($internal) {
        $slash = (substr($image_url, 0, 1) == '/') ? '' : '/';
        $image_url = $this->source_base_url . $slash . $image_url;
      }
    }
    // Parse the url path.
    $parsed_url = parse_url($image_url);
    $image_path = str_replace(' ', '_', $parsed_url['path']);
    $image_path = str_replace('%20', '_', $image_path);
    $image_file = basename($image_path);
    $file_parts = explode('.', $image_file);
    if (!isset($file_parts[1])) {
      $image_ext = 'jpg';
      $image_path .= '.jpg';
    }
    else {
      $image_ext = strtolower(array_pop($file_parts));
    }
    // Only operate on valid internal images.
    $valid_exts = array('bmp', 'jpg', 'jpeg', 'gif', 'tiff', 'svg', 'png');
    if ($internal && in_array($image_ext, $valid_exts)) {
      $image_title = substr(implode('_', explode('/', $image_path)), 1);
      $image_dir = 'public:/' . substr($image_path, 0, strpos($image_path, $image_file));
      $uri = 'public:/' . $image_path;
      // Test if the file exists and load if it does (prevents duplicates).
      if (($fid = db_select('file_managed', 'f')
          ->fields('f', array('fid'))
          ->condition('type', 'image')
          ->condition('uri', $uri)
          ->execute()
          ->fetchField()) && file_exists($uri)) {
        $file = file_load($fid);
      }
      else {
        // Prepare to download the image.
        if (!file_exists($image_dir)) {
          drupal_mkdir($image_dir, NULL, TRUE);
        }
        $deleted = db_delete('file_managed')
                     ->condition('type', 'image')
                     ->condition('uri', $uri)
                     ->execute();
        if ($file = system_retrieve_file($image_url, $uri, TRUE, FILE_EXISTS_REPLACE)) {
          // Edit the file.
          $this->setFileMetaData($file, $alt, $title, $filename, $tag);
        }
      }
    }
    return $file;
  }

  /**
   * Custom function to add metadata to a file object.
   */
  protected function setFileMetaData($file, $alt, $title, $filename = NULL, $tag = NULL) {
    $lang = LANGUAGE_NONE;
    $uid = 1;
    $file->uid = $uid;
    $file->display = 1;
    $file->description = $title;
    $file->field_file_image_alt_text[$lang][0]['value']  = $alt;
    $file->field_file_image_title_text[$lang][0]['value']  = $title;
    /* The following assumes a "media_tags" vocabulary.
    if ($tag !== NULL) {
      $file->field_media_tags[$lang][0]['tid']  = $this->prepareTag($tag, 'media_tags');
    }
    if ($filename !== NULL) {
      $file->filename = $filename;
    }
    */
    file_save($file);

  }

  /**
   * Custom function to return an existing TID, or create if none exists.
   */
  protected function prepareTag($term_name, $vocabulary_name) {
    $term_arr = taxonomy_get_term_by_name($term_name, $vocabulary_name);
    if (empty($term_arr)) {
      if ($vocabulary = taxonomy_vocabulary_machine_name_load($vocabulary_name)) {
        $term = new stdClass();
        $term->name = $term_name;
        $term->vid = $vocabulary->vid;
        taxonomy_term_save($term);
        $tid = $term->tid;
      }
    }
    else {
      $tid = array_pop($term_arr)->tid;
    }
    return $tid;
  }

  /**
   * Custom function to properly set aliases that have exceptions.
   */
  public function checkForCustomAlias($alias) {
    $aliases = array(
      'some-source-alias' => 'what-should-be-the-destination-alias',
    );
    if (isset($aliases[$alias])) {
      return $aliases[$alias];
    }
    else {
      return $alias;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function setRedirect($normal_path, $redirect_path) {
    $redirect = new stdClass();

    $value = $this->checkForCustomRedirect($redirect_path);
    module_invoke(
      'redirect',
      'object_prepare',
        $redirect,
      array(
        'source' => $value['source'],
        'source_options' => $value['source_options'],
        'redirect' => $normal_path,
        'redirect_options' => array(),
        'language' => LANGUAGE_NONE,
      )
    );
    module_invoke('redirect', 'save', $redirect);
  }

  /**
   * Custom function to properly set/prepare redirects.
   */
  public function checkForCustomRedirect($alias) {
    $redirects = array(
      'some-destination-alias' => 'what-should-be-the-source-alias',
    );

    if (isset($redirects[$alias])) {
      $alias = $redirects[$alias];
    }
    $source = parse_url($alias, PHP_URL_PATH);
    parse_str(parse_url($alias, PHP_URL_QUERY), $source_options);

    return array('source' => $source, 'source_options' => $source_options);
  }
}
