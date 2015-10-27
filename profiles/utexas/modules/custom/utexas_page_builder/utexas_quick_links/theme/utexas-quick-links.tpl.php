<?php
/**
 * @file
 * Compound field template for Social Links.
 *
 * Available variables:
 *  - $classes: A string of classes to add to the field collection item.
 *  - $attributes: A string representing attributes to add to this item.
 *  - $content_attributes: Content attributes for the item.
 *  - $headline: The defined headline
 *  - $links: an array of user-defined links, with social media name
 *  - $page_template: the human readable name of the page template of the node.
 *  - $quick_links_region: machine name of the region of the Quick Links block.
 *
 * @ingroup themeable.
 */
?>
<h3 class="sidebar-headline"><?php print $headline; ?></h3>
<?php
if ($copy != FALSE) :
  echo '<div class="body-copy"><p>' . $copy . '</p></div>';
endif;
if ($links != FALSE) :
  if ($page_template == 'P2H2') :
    echo '<div class="row">';
    print render($links);
    echo '</div>';
  else :
    print render($links);
  endif;
endif;
