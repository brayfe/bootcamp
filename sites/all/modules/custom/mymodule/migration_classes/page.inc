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

    $query->leftjoin('content_field_body_2', 'b', 'n.vid = b.vid');
    $query->leftjoin('content_field_header_image', 'h', 'n.vid = h.vid');

    $query->fields('h', array(
      'field_header_image_fid',
    ));

    $query->fields('b', array(
      'field_body_2_value',
    ));

    //$query->condition('status', '0', '!=');
    $query->range(0, 500);

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

    // For fields that include a switchable text format filter, we need to
    // define the format that should be used.
    $this->addFieldMapping('field_wysiwyg_b', 'field_body_2_value');
    $this->addFieldMapping('field_wysiwyg_b:format', 'format')
      ->defaultValue('filtered_html');

    /*
    // The following would work in most instances, assuming a relational URL
    // alias table. Drupal 6 does not have this.
    $this->addFieldMapping('DESTINATION', 'SOURCE');
    $this->addFieldMapping('pathauto')
         ->defaultValue(FALSE);
    */
  }

  /**
   * After preImport, will contain an array of all fids & filepaths, in the form
   * key = fid, value = filepath (relative to the docroot)
   */
  public $files_map = array();

  /**
   * Runs once, rather than as part of each row.
   * Executes before the first row has been imported.
   */
  public function preImport() {
    parent::preImport();

    db_set_active('legacy');
    $query = db_query('SELECT fid,filepath FROM {files}');
    $files = $query->fetchAllAssoc('fid');
    foreach ($files as $file) {
      $this->file_map[$file->fid] = $file->filepath;
    }
    db_set_active('default');
  }

  /**
   * Provides the ability to alter the $row before saving.
   *
   * General purpose "tamper" of data that comes directly from a source row.
   * Also commonly use to "skip" rows that meet any criteria by returning FALSE.
   */
  public function prepareRow($row) {
    parent::prepareRow($row);

    if ($row->field_body_2_value != '') {
      $row->field_body_2_value = check_markup($row->field_body_2_value, 'filtered_html');
      drupal_set_message($row->title);
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
    // Set the hero image from the "Header Image".
    if (isset($row->field_header_image_fid) && $row->field_header_image_fid != '') {
      $source_fid = $row->field_header_image_fid;
      // Retrieve the image URL.
      if (isset($this->file_map[$source_fid])) {
        // Save the image into the Destination's file_managed table.
        $image_url = $this->source_base_url . '/' . $this->file_map[$source_fid];
        if ($file = $this->fileAddImage($image_url, $node->title, $node->title, $node->title)) {
          // Set the field_utexas_hero_image fid to the file->fid.
          $node->field_utexas_hero_photo[LANGUAGE_NONE][0]['image_fid'] = $file->fid;
          $node->field_utexas_hero_photo[LANGUAGE_NONE][0]['caption'] = $node->title;
        }
      }
    }
  }
}
