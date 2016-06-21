<?php
/**
 * @file
 * Template for an accordion field.
 */
?>
<!-- accordion -->
<dl class="accordion" data-accordion>
  <dd class="accordion-navigation">
    <a href="#panel<?= $id ?>"><?= $title ?></a>
    <div id="panel<?= $id ?>" class="content<?php $expanded ? print ' active' : false; ?>">
      <?= $body ?>
    </div>
  </dd>
</dl>
