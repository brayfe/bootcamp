<?php
/**
 * @file
 * Code for the mymodule migration module.
 */

// Must be included, as Drupal 7 doesn't have namespace autoloading.
module_load_include('inc', 'mymodule', 'migration_classes/mymodule_base_migration');

/**
 * Migration class to import page nodes.
 */
class pageMigration extends mymoduleBaseMigration {
  /**
   * {@inheritdoc}
   */
  public function __construct($arguments) {
    parent::__construct($arguments);
    $this->description = t('Import pages from source database.');
    $query = Database::getConnection('default', 'legacy')
      ->select('node', 'n')
      ->condition('type', 'page', '=');
      //->condition('nid', '499', '=');

    $query->fields('n', array(
      'nid',
      'vid',
      'title',
      'created',
      'promote',
      'sticky',
    ));

    //$query->condition('status', '0', '!=');
    //$query->range(0, 10);

    $this->source = new MigrateSourceSQL($query);
    // Use the MigrateDestinationNode class to define a standard node migration.
    $this->destination = new MigrateDestinationNode('standard_page');

    // Create a map object for tracking the relationships between source rows.
    $this->map = new MigrateSQLMap($this->machineName,
      array(
        // The 'id' field in the SQL table is the key.
        'vid' => array(
          'type' => 'int',
          'length' => 10,
          'not null' => TRUE,
          'description' => 'Page VID',
          'alias' => 'n',
        ),
      ),
      // Rather than specifying the type directly here, we would probably use
      // arguments, but instead this just specifies the 'product' product type
      // to make it obvious what's going on.
      MigrateDestinationNode::getKeySchema()
    );

    $this->addFieldMapping('title', 'title');
    $this->addFieldMapping('created', 'created');
    $this->addFieldMapping('sticky', 'sticky');
    $this->addFieldMapping('promote', 'promote');

  }

  /**
   * Runs once, rather than as part of each row.
   * Executes before the first row has been imported.
   */
  public function preImport() {
    parent::preImport();

  }

  /**
   * Provides the ability to alter the $row before saving.
   *
   * General purpose "tamper" of data that comes directly from a source row.
   * Also commonly use to "skip" rows that meet any criteria by returning FALSE.
   */
  public function prepareRow($row) {
    parent::prepareRow($row);

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
}
