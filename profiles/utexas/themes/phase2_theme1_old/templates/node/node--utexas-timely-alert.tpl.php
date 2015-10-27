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
$cta_title = !empty($content['field_call_to_action_link']['0']['#element']['title']) ? render($content['field_call_to_action_link']['0']['#element']['title']) : '' ;
$cta_link = !empty($content['field_call_to_action_link']['0']['#element']['url']) ? render($content['field_call_to_action_link']['0']['#element']['url']) : '' ;
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
          <?php print (!empty($content['body']['0']['#markup'])) ? render($content['body']['0']['#markup']) : t('') ?>
        </div>
          <?php
          if(!empty($cta_link)){
            !empty($cta_title) ? print('<a href="'.$cta_link.'" class="cta">'.$cta_title.'</a>') : print('<a href="'.$cta_link.'" class="cta">'.$cta_link.'</a>');
          }
          ?>
      </div>
    </div>
  </div>
</div>

