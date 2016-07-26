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
