<?php
/**
 * @file
 * Partial file to render the Timely Announcement locked field.
 */

if (isset($locked_fields['field_timely_announcement'])) :
  print render($locked_fields['field_timely_announcement']);
endif;
