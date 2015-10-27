<?php
/**
 * @file
 *
 * Available variables:
 *  - $classes: A string of classes to add to the field collection item.
 *  - $attributes: A string representing attributes to add to this item.
 *  - $content_attributes: Content attributes for the item.
 *  - $content: The content itself.
 *  - $values: Rendered values of the fields.
 *
 * @see template_preprocess_node().
 *
 * @ingroup themeable.
 */
?>
<div class="container field_timely_announcement">
  <div class="row">
    <div class="column medium-12">
      <div class="notice-wrapper">
        <h4>
          <span class="icon-beacon"></span>
          <?php print (!empty($title)) ? render($title) : t('Alert') ?>
        </h4>
         <div class="alert-text">
          <?php print (!empty($content['field_predefined_message']['0']['#markup'])) ? render($content['field_predefined_message']['0']['#markup']) : t('') ?>
        </div>
      </div>
    </div>
  </div>
</div>

