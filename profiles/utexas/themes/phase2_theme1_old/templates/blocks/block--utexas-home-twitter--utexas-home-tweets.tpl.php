<?php
/**
 * @file
 * Twitter blocks. Used in both Core Home and Core Pages.
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
<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>
  <div class="container-flush container-tweets">
    <div class="news-module news-module-secondary">
      <div class="module-headline"><?php print t($block->subject) ?></div>
      <?php print $content ?>
    </div>
  </div>
</div>
