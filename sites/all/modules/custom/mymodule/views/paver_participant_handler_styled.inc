<?php
/**
 * @file
 * Definition of utexas_events_handler_operations.
 */

/**
 * Provides a custom views field.
 */
class paver_participant_handler_styled extends views_handler_field {
  /**
   * Render a numeric value as a size.
   *
   * @ingroup views_field_handlers
   */
  public function option_definition() {
    $options = parent::option_definition();
    return $options;
  }

  /**
   * Default options form that provides label widget all fields should have.
   */
  public function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
  }

  /**
   * Render the field.
   *
   * @param object $values
   *   The values retrieved from the database.
   */
  public function render($values) {
    $id = $values->id;
    $output = '';
    $entity = entity_load_single('paver_participant', $id);
    if (isset($entity->field_paver_style[LANGUAGE_NONE])) {
      $paver = entity_load_single('paver', $entity->field_paver_style[LANGUAGE_NONE][0]['target_id']);
      $output .= '<p style="background:lightgray;width:80;height:40;text-align:center;">Line 1<br />Line 2<br />Line 3</p>';
    }
    return $output;
  }
}
