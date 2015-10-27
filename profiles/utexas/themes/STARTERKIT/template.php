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
}
