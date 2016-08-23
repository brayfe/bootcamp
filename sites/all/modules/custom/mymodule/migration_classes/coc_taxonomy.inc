<?php

/**
 * @file
 * Migrate all Book series.
 *
*/

class cocTaxonomyMigration extends mymoduleBaseMigration {
  public function __construct($arguments) {
    parent::__construct($arguments);
    $this->description =
      t('Migrate taxonomy from the source database to taxonomy terms');

    $query = Database::getConnection('default', 'legacy')
      ->select('term_data', 't')
      ->distinct()
      ->condition('vid', '2', '=')
      ->groupby('tid');

    //$query->range(0, 50);

    $query->fields('t', array(
      'tid',
      'name',
      'description',
    ));

    $this->source = new MigrateSourceSQL($query);

    // The vocabulary machine name.
    $this->destination =
      new MigrateDestinationTerm('tags');

    // Create a map object for tracking the relationships between source rows.
    $this->map = new MigrateSQLMap($this->machineName,
      array(
        'tid' => array('type' => 'varchar',
                         'length' => 255,
                         'not null' => TRUE,
                         'description' => 'Series ID',
                        )
      ),
      MigrateDestinationTerm::getKeySchema()
    );

    $this->addFieldMapping('name', 'name');
    $this->addFieldMapping('description', 'description');
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow($row) {
    if (parent::prepareRow($row) === FALSE) {
      return FALSE;
    }

    if ($row->name == 'Approved Courses') {
      $row->name = "Hello Francine";
    }
    return TRUE;
  }

  /**
   * Provides the ability to alter the $node before saving.
   *
   * Useful if you do not have a source row to migrate from, e.g., you're
   * creating a taxonomy term based on a combination of other values.
   */
  public function prepare($term, stdClass $row) {
    $term->description .= " this is a random description.";
  }
}
