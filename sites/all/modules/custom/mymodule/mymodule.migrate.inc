<?php
/**
 * @file
 * Code for the mymodule migration module.
 */

/**
 * Implements hook_migrate_api().
 */
function mymodule_migrate_api() {
  /*
  See https://www.drupal.org/node/2136601 for performance optimizations.
  */
  $api = array(
    'api' => 2,
    'groups' => array(
      'mymodule_migration' => array(
        'title' => t('Drupal 6 to Drupal 7 Migration'),
        'default_format' => 'filtered_html',
      ),
    ),
    'migrations' => array(
      'coc_taxonomy' => array(
        'class_name' => 'cocTaxonomyMigration',
        'group_name' => 'mymodule_migration',
      ),
      'page' => array(
        'class_name' => 'pageMigration',
        'group_name' => 'mymodule_migration',
          'dependencies' => array(
          'coc_taxonomy',
        ),
      ),
    ),
  );
  return $api;
}
