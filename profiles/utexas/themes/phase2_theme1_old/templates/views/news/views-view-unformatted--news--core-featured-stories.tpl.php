<?php
/**
 * @file
 * Simple view template to display row values for Core Home Featured Stories.
 *
 * @ingroup views_templates
 */
?>
<?php foreach ($rows as $id => $row): ?>
  <div class="news-post">
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
