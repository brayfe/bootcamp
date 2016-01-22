<?php
/**
 * @file
 * Main template file for subtheme of forty_acres theme.
 */

/**
 * Preprocessor for page.tpl.php.
 *
 * Adds in new stylesheets for base, core home,
 * core pages. Also handles adding new javascript, and setting page theme
 * suggestions based on the field_template value. It also throws the menus into
 * a variable on the $page array, and defines the partials directory.
 *
 * Finally, it associates the 404 and 403 pages with their theme suggestions.
 */
function STARTERKIT_preprocess_page(&$vars, $hook) {
  $vars['partials_dir'] = __DIR__ . '/templates/partials/';

  // Load foundation js files selected in theme settings.
  $path = drupal_get_path('theme', 'STARTERKIT');
  $extra_libraries = theme_get_setting('foundation_files') ? theme_get_setting('foundation_files') : array();
  foreach ($extra_libraries as $library => $value) {
    if ($library === $value) {
      drupal_add_js($path . '/js/foundation.' . $library . '.js', array(
        'scope' => 'foot_scripts',
        'weight' => 4,
      ));
      if (file_exists($path . '/css/foundation.' . $library . '.css')) {
        drupal_add_css($path . '/css/foundation.' . $library . '.css');
      }
    }
  }
}
