<?php
/**
 * @file
 * Partial file to display miscellaneous page information (messages, tabs).
 */

if ($messages) :
  ?>
  <div class="row">
    <div class="column small-12">
      <div id="console" class="clearfix"><?php print $messages; ?></div>
    </div>
  </div>
 <?php
endif;
if ($tabs) :
  ?>
  <div class="row">
    <div class="column small-12">
      <?php print render($tabs); ?>
    </div>
  </div>
  <?php
endif;
