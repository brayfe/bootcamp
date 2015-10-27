<?php
/**
 * @file
 * Partial file to render the Timely Announcement locked field.
 *
 * @todo ITS may need to remove or revise this page once the final Timely
 *   Announcement implementation is complete.
 */
?>
<?php if (isset($locked_fields['field_timely_announcement'])): ?>
  <?php print render($locked_fields['field_timely_announcement']); ?>
<?php endif; ?>
