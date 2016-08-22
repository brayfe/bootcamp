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

    if ($row->name == '') {
      return FALSE;
    }
    return TRUE;
  }
}
