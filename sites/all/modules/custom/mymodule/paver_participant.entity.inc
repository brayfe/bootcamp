<?php
/**
 * Module file for Mymodule.
 */

/**
 * PaverParticipant entity class extending the Entity class
 */
class PaverParticipantEntity extends Entity {
  /**
   * Change the default URI from default/id to project/id
   */
  protected function defaultUri() {
    return array('path' => 'paver-participant/' . $this->identifier());
  }

}

/**
 * Extending the EntityAPIController for the PaverParticipant entity.
 */
class PaverParticipantEntityController extends EntityAPIController {
  public function buildContent($entity, $view_mode = 'full', $langcode = NULL, $content = array()) {
    $build = parent::buildContent($entity, $view_mode, $langcode, $content);
    // Our additions to the $build render array
    return $build;
  }
}

/**
 * Extends the EntityDefaultViewsController class.
 */
class PaverParticipantViewsController extends EntityDefaultViewsController {
  /**
   * Edit or add extra fields to views_data().
   */
  public function views_data() {
    $data = parent::views_data();
    // Define custom views handlers for various entity fields.
    $data['mymodule_paver_participant']['styled_paver'] = array(
      'title' => 'Styled Paver',
      'help' => 'Display a styled paver',
      'field' => array(
        'real field' => 'id',
        'handler' => 'paver_participant_handler_styled',
        'click sortable' => 1,
        'float' => '',
      ),
    );
    return $data;
  }
}
