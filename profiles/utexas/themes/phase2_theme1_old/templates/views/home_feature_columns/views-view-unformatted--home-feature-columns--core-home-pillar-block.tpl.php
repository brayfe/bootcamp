<?php
/**
 * @file
 * Simple view template to display row values for Core Home Pillars.
 *
 * @ingroup views_templates
 */
?>
<?php foreach ($rows as $id => $row): ?>
  <div class="column small-6 medium-3">
    <div class="pillar" data-equalizer-watch="">
      <?php print $row; ?>
    </div>
  </div>
<?php endforeach; ?>
