<?php
/**
 * @file
 * Generic fieldblock theme.
 *
 * Available variables:
 *  - $block: The block object itself.
 *  - $block_html_id: ID of this block.
 *  - $classes: Classes for this block.
 *  - $attributes: Extra attributes for this block.
 *  - $content_attributes: Extra attributes for the content of this block.
 *  - $content: Content of this block.
 *  - $editable: Whether or not the block is editable by the Layout Editor.
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
  <div class="content"<?php print $content_attributes; ?>>
    <?php print $content ?>
  </div>
</div>