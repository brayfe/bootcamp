<?php
/**
 * @file
 * Core featured stories block.
 *
 * Available variables:
 *  - $block: The block object itself.
 *  - $block_html_id: ID of this block.
 *  - $classes: Classes for this block.
 *  - $attributes: Extra attributes for this block.
 *  - $content_attributes: Extra attributes for the content of this block.
 *  - $content: Content of this block.
 *
 * @see template_preprocess_block().
 *
 * @ingroup themeable.
 */
?>
<?php if ($block->edit_links): ?>
  <div class="edit-links">
    <?php print $block->edit_links; ?>
  </div>
<?php endif; ?>
<div class="container-flush container-featured">
  <div class="news-module">
    <div class="module-headline"><?php print $block->subject; ?></div>
    <?php print l(t('View all stories'), 'news', array('absolute' => TRUE, 'attributes' => array('class' => array('cta', 'module-cta')))); ?>
    <?php print $content; ?>
  </div>
</div>
