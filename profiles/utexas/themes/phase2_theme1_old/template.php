<?php
/**
 * @file
 * Main template file for phase2_theme1 theme. Creates a way to include hooks in their
 * own separate files.
 */

/**
 * UT Core theme hook directory.
 */

/**
 * Implements hook_html_head_alter(). Remove some HTML head elements.
 */
function phase2_theme1_html_head_alter(&$head_elements) {
  // Strip the generator link.
  unset($head_elements['system_meta_generator']);

  // Strip the default favicon.
  unset($head_elements['drupal_add_html_head_link:shortcut icon:http://phase2_theme1.dev/misc/favicon.ico']);

  // Strip the RSS link.
  unset($head_elements['drupal_add_html_head_link:alternate:http://phase2_theme1.dev/rss.xml']);

  // unset the dafault favicon
  foreach ($head_elements as $key => $element) {
    if (!empty($element['#attributes'])) {
      if (array_key_exists('href', $element['#attributes'])) {
        if (strpos($element['#attributes']['href'], 'misc/favicon.ico') > 0) {
          unset($head_elements[$key]);
        }
      }
    }
  }
}

/**
 * Theme override for menu links for the core helpful links menu.
 */
function phase2_theme1_menu_link__menu_core_helpful_links(array $variables){
  // Grab the element (represents the <a> element) from the variables array.
  $element = $variables['element'];

  // Add classes attribute for the element.
  $element['#localized_options']['attributes']['class'] = array('cta-link', 'sans');

  // Create the menu link using the Drupal l function.
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);

  // Return the link embedded in a list element.
  return '<li>' . $output . "</li>\n";
}

/**
 * Theme override for the menu tree for the core helpful links menu.
 */
function phase2_theme1_menu_tree__menu_core_helpful_links($variables){
  // We don't want a wrapper for this menu, so just return the tree.
  return '<ul>' . $variables['tree'] . '</ul>';
}

/**
 * Theme override for theme_menu_link().
 */
function phase2_theme1_menu_link__menu_directory(array $variables){
  // Grab the element (represents the <a> element) from the variables array.
  $element = $variables['element'];

  // Add a class attribute for the element.
  $element['#localized_options']['attributes']['class'] = array('nav-link');

  // Grab the position.
  $position = $element['#attributes']['class'][0];

  // Set class based on the position.
  switch($position) {
    case 'first':
      $link_class = 'first';
      break;

    case 'last':
      $link_class = 'last';
      break;

    case 'leaf':
      $link_class = 'mid';
      break;

    default:
      $link_class = '';
      break;
  }

  // Create the menu link using the Drupal l function.
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);

  // Return the link embedded in a list element with the the set list item
  // class.
  return '<li class="nav-item nav-item-info ' . $link_class . '" role="menuitem">' . $output . "</li>\n";
}

/**
 * Theme override for theme_menu_tree().
 */
function phase2_theme1_menu_tree__menu_directory($variables){
  // We don't need a wrapper for this menu, so just return the tree.
  return $variables['tree'];
}

/**
 * Theme override for theme_menu_link().
 */
function phase2_theme1_menu_link__menu_footer(array $variables){
  // Grab the element (represents the <a> element) from the variables array.
  $element = $variables['element'];

  // Add classes attribute for the element.
  $element['#localized_options']['attributes']['class'] = array('helpful-link');

  // Create the menu link using the Drupal l function.
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);

  // Return the link embedded in a list element.
  return '<li class="helpful-link-item" role="menuitem">' . $output . "</li>\n";
}

/**
 * Theme override for theme_menu_tree();
 */
function phase2_theme1_menu_tree__menu_footer($variables){
  // Add classes to the wrapper and return with the menu tree.
  return '<ul class="helpful-links small-block-grid-2 medium-block-grid-3" role="menu">' . $variables['tree'] . '</ul>';
}

/**
 * Theme override for theme_menu_link().
 */
function phase2_theme1_menu_link__menu_persona(array $variables) {
  // Grab the element (represents the <a> element) from the variables array.
  $element = $variables['element'];

  // Add a class attribute for the element.
  $element['#localized_options']['attributes']['class']= array('nav-link');

  // Create a list of classes to add to the link.
  $classes = array('nav-item');

  // Create the menu link using the Drupal l function.
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);

  // Return the link embedded in a list element.
  return '<li class="'. implode(' ', $classes). '" role="menuitem">' . $output . "</li>\n";
}

/**
 * Theme override for theme_menu_tree().
 */
function phase2_theme1_menu_tree__menu_persona($variables){
  // Add a class to the wrapper.
  return '<ul class="topnav-constituents" role="menu">' . $variables['tree'] . '</ul>';
}

/**
 * Theme override for theme_menu_link().
 */
function phase2_theme1_menu_link__menu_secondary_navigation(array $variables){
  // Grab the element (represents the <a> element) from the variables array.
  $element = $variables['element'];

  // Add classes attribute for the element.
  $element['#localized_options']['attributes']['class'] = array('nav-link','nav-link-button');

  // Create the menu link using the Drupal l function.
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);

  // Return the link embedded in a list element.
  return '<li class="nav-item nav-item-button show-for-large-up" role="menuitem">' . $output . "</li>\n";
}

/**
 * Theme override for theme_menu_tree().
 */
function phase2_theme1_menu_tree__menu_secondary_navigation($variables){
  // We don't want a wrapper for this menu so just return the tree.
  return $variables['tree'];
}

/**
 * Theme override for theme_breadcrumb(). Insert themed breadcrumb page
 * navigation at top of the node content.
 *
 * Breadcrumb array looks like this:
 * Array ( [0] => Home [1] => Campus Life [2] => Living & Eating )
 *
 * $breadcrumb[1] should not have a link, since it is a landing page that does
 * not exist.
 */
function phase2_theme1_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    $output = '';

    // Grab the count of the breadcrumb items.
    $total = count($breadcrumb);

    switch($total) {
      case ($total > 2):
        // Build a new array and add the first breadcrumb.
        $trail = array();
        $trail[] =  $breadcrumb[0];

        // Grab the position of the closing element.
        $pos = strpos( $breadcrumb[2],'>');

        // Create a new link by combining the 1st and second breadcrumbs.
        $new_link = substr_replace($breadcrumb[2], strip_tags($breadcrumb[1]) . ' : ', $pos + 1, 0);

        // Add the new link to the array.
        $trail[] = $new_link;

        // Add the remaining breadcrumbs.
        for ($i = 3; $i < $total; $i++) {
          $trail[] = $breadcrumb[$i];
        }

        // Append the current page title.
        $trail[] = drupal_get_title();
        $breadcrumb = $trail;

        break;

      case ($total == 2):
        // Remove any tags from the last breadcrumb.
        $last_element = strip_tags(array_pop($breadcrumb));

        // Combine the text of the last breadcrumb and the current page title.
        $breadcrumb[] = $last_element . ' : ' . drupal_get_title();

        break;

      default:
        // Combine the text of the last breadcrumb and the current page title.
        $breadcrumb[] = drupal_get_title();

        break;
    }

    // Make the list attribute-able.
    foreach ($breadcrumb as $key => &$crumb) {
      $crumb = array('data' => $crumb);
      if ($key == count($breadcrumb) - 1) {
        $crumb['class'] = array('current');
      }
    }

    return $output . theme('item_list', array(
      'items' => $breadcrumb,
      'type' => 'ul',
      'title' => NULL,
      'attributes' => array(
      'class' => array('breadcrumbs'),
      ),
    ));
  }
}

/**
 * Theme override for theme_item_list().
 */
function phase2_theme1_item_list($variables) {
  $items = $variables['items'];
  $title = $variables['title'];
  $type = $variables['type'];
  $attributes = $variables['attributes'];

  // Only output the list container and title, if there are any list items.
  // Check to see whether the block title exists before adding a header.
  // Empty headers are not semantic and present accessibility challenges.
  $output = '';
  if (isset($title) && $title !== '') {
    $output .= '<h3>' . $title . '</h3>';
  }

  if (!empty($items)) {
    // Open the list.
    $output .= "<$type" . drupal_attributes($attributes) . '>';

    // Figure out how many items we have.
    $num_items = count($items);
    $i = 0;

    // Loop through passed items.
    foreach ($items as $item) {
      $attributes = array();
      $children = array();
      $data = '';
      $i++;

      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          } elseif ($key == 'children') {
            $children = $value;
          } else {
            $attributes[$key] = $value;
          }
        }
      } else {
        $data = $item;
      }

      // We have children, so render the nested list.
      if (count($children) > 0) {
        $data .= theme_item_list(array(
          'items' => $children,
          'title' => NULL,
          'type' => $type,
          'attributes' => $attributes
        ));
      }

      // Add some classes to the element, as necessary.
      if ($i == 1) {
        $attributes['class'][] = 'first';
      }
      if ($i == $num_items) {
        $attributes['class'][] = 'last';
      }

      // Attach the output to the list item.
      $output .= '<li' . drupal_attributes($attributes) . '>' . $data . "</li>\n";
    }

    // Close the list.
    $output .= "</$type>";
  }

  return $output;
}

/**
 * Implements template_preprocess_block(). Attaches field information to
 * fieldblock blocks, prepares blocks for the layout editor, and applies default
 * classes to blocks in the sidebars.
 *
 * @see theme_context_block_edit_wrap().
 *
 * @todo ITS to override twitter component on this page after writing the new
 *   Twitter feed module.
 */
function phase2_theme1_preprocess_block(&$variables) {
  // Attach a theme hook suggestions for fieldblocks based on the content in
  // the field.
  if (isset($variables['block']) and $variables['block']->module == 'fieldblock' and isset($variables['elements']['#field_name'])) {
    // Attach some extra theme hooks for extended customization.
    $variables['theme_hook_suggestions'][] = 'block__fieldblock__' . $variables['elements']['#field_name'];
    $variables['theme_hook_suggestions'][] = 'block__fieldblock__' . $variables['block']->region . '__' . $variables['elements']['#field_name'];

    // Attach the items to the block.
    $items = array();
    foreach (element_children($variables['elements']) as $key) {
      if (is_numeric($key)) {
        $items[] = $variables['elements'][$key];
      }
    }
    $variables['field_items'] = $items;

    // Attach markup to make the block editable via the context UI. If we are
    // rendering field items in the block--fieldblock.tpl.php (and not rendering
    // $content), we need to add the $editable variable to let the fieldblock be
    // rearranged via the context UI.
    //
    // Before this, make sure the user has permission to edit before adding the
    // $editable variable for their use.
    $block = $variables['block'];
    $variables['editable'] = FALSE;
    if (user_access(UTEXAS_PAGE_EDIT_LAYOUT_EDIT_PERMISSION) and isset($block->context)) {
      $variables['editable'] = "<a id='context-block-{$block->module}-{$block->delta}' class='context-block editable edit-{$block->context}'></a>";
    }
  }

  // Stick a class of sidebar module on a block if it's in the sidebar.
  if ($variables['block']->region == 'sidebar_second') {
    // Make sure we're not adding this to content areas.
    $variables['classes_array'][] = 'sidebar-module';

    // Set certain regions to be default to no sidebar style.
    $no_default = array(
      'field_utexas_flex_content_area_a',
      'field_utexas_flex_content_area_b',
      'field_wysiwyg_a',
      'field_wysiwyg_b',
      'field_utexas_contact_info',
      'field_utexas_social_links',
      'field_utexas_image_link_a',
      'field_utexas_image_link_b',
      'field_gift_link',
    );
    if (isset($variables['elements']['#field_name']) and !in_array($variables['elements']['#field_name'], $no_default)) {
      $variables['classes_array'][] = 'sidebar-default-style';

      // Find the region key.
      $key = array_search('block__' . $variables['block']->region, $variables['theme_hook_suggestions']);
      $hooks = phase2_theme1_array_insert_after($key, $variables['theme_hook_suggestions'], 'new_theme_hook', 'block__' . $variables['block']->region . '__default_style');
      $variables['theme_hook_suggestions'] = array_values($hooks);
    }

    // If it's a non-field (i.e. news block or localist block), attach the
    // default style as well.
    if (!isset($variables['elements']['#field_name'])) {
      $variables['classes_array'][] = 'sidebar-default-style';
      $variables['theme_hook_suggestions'][] = 'block__' . $variables['block']->region . '__default_style';
    }

    // Custom override for twitter block.
    // @todo ITS to revise this section, as needed.
    if ($variables['block']->module == 'phase2_theme1_home_twitter') {
      $classes = array_diff($variables['classes_array'], array('sidebar-default-style'));
      $classes[] = 'sidebar-twitter-style';
      $variables['classes_array'] = array_values($classes);
    }
  }
}


/**
 * Helper function to insert a new value after a key.
 *
 * @param mixed $key
 *   An array key to insert a new key/value pair after.
 * @param array $array
 *   The array to search for a key on.
 * @param mixed $new_key
 *   The new key to be inserted.
 * @param mixed $new_value
 *   The new value to be inserted.
 *
 * @return mixed
 *   FALSE if the key wasn't found.
 *   The new key/value pair.
 */
function phase2_theme1_array_insert_after($key, array &$array, $new_key, $new_value) {
  if (array_key_exists($key, $array)) {
    $new = array();
    foreach ($array as $k => $value) {
      $new[$k] = $value;
      if ($k === $key) {
        $new[$new_key] = $new_value;
      }
    }
    return $new;
  }
  return FALSE;
}

/**
 * Implements theme_preprocess_theme. Used to change the context block
 * browser's available fields based off of what the user has selected for their
 * template.
 */
function phase2_theme1_preprocess_context_block_browser(&$variables) {
  // Create a list of modules to display in the browser, keyed to the caption.
  $available_modules = array(
    'fieldblock' => t('Page Components'),
    'phase2_theme1-home-twitter' => t('Twitter Feeds'),
    'views' => t('Views')
  );

  // Reassign blocks based on available modules.
  $modules = array_keys($available_modules);
  $blocks  = array();

  foreach ($variables['blocks'] as $key => $block_list) {
    if (in_array($key, $modules)) {
      // Make sure the module can work.
      if ($key == 'views' and function_exists('_page_edit_get_view_display_from_block_delta')) {
        foreach ($block_list as $block_id => &$block) {
          // Check to make sure this view has been exposed to the layout editor.
          if ($display = _page_edit_get_view_display_from_block_delta($block->delta)) {
            if (!(isset($display->display_options['block_exposed_to_editor']) and $display->display_options['block_exposed_to_editor'])) {
              // Since this block can't be exposed, remove it from the block
              // editor.
              unset($block_list[$block_id]);
            }
          }
        }
      }

      // Attach the block list to the blocks array, if there's anything in that
      // block list.
      if (count($block_list) >= 0) {
        $blocks[$key] = $block_list;
      }
    }
  }

  // Change the categories.
  $categories = array(
    0 => '<' . t('all components') . '>'
  );
  foreach ($available_modules as $key => $block) {
    $categories[$key] = $block;
  }

  // Assign the variables.
  $variables['categories']['#options'] = $categories;
  $variables['available_modules'] = $available_modules;

  // Change the helper text.
  $variables['help_text']['#markup']  = '<p>' . t('To add a component to the
    page, click on the component. You can then drag and drop components into
    different regions on the page.') . '</p>';
  $variables['help_text']['#markup'] .= '<p>' . t('You can additionally filter
    by component type.') . '</p>';

  // Reset the blocks.
  $variables['blocks'] = $blocks;
}

/**
 * The name of the field collection item entity.
 */
define('FORTY_ACRES_FIELD_COLLECTION_ITEM_ENTITY_TYPE', 'field_collection_item');

/**
 * Implements template_preprocess_entity. We're wanting to grab all of the
 * fields per entity to expose as a simple value in a
 * field-collection-item.tpl.php template.
 *
 * @see template_preprocess_entity().
 * @see field-collection-item.tpl.php
 */
function phase2_theme1_preprocess_entity(&$variables) {
  // Add in variables for the defined field collections.
  if ($variables['entity_type'] == FORTY_ACRES_FIELD_COLLECTION_ITEM_ENTITY_TYPE) {
    $collection = $variables[FORTY_ACRES_FIELD_COLLECTION_ITEM_ENTITY_TYPE];

    // Get the field names.
    $field_info = field_info_instances(FORTY_ACRES_FIELD_COLLECTION_ITEM_ENTITY_TYPE, $collection->field_name);
    $fields = array_keys($field_info);
    $temp = array();

    // Iterate over the fields.
    foreach ($fields as $field) {
      // Grab the items of the field.
      $items = field_get_items(FORTY_ACRES_FIELD_COLLECTION_ITEM_ENTITY_TYPE, $collection, $field);
      $value = array();
      $view  = $field_info[$field]['display']['default'];

      // Only continue if there are items stored in the field.
      if ($items) {
        // Throw the items into a sub array.
        foreach ($items as $item) {
          // Custom validation
          switch ($field) {
            // Display the markup for embed codes.
            case 'field_embed_code':
              $value[] = check_markup($item['value'], 'embeds');
              break;

            // Pass in the markup for the photo.
            case 'field_photo':
              // Grab the alt tag.
              $entity = file_load($item['fid']);
              $alt_tag = field_get_items('file', $entity, 'field_alt_tag');
              if ($alt_tag) {
                $alt_tag = field_view_value('file', $entity, 'field_alt_tag', $alt_tag[0]);
                $alt_tag = drupal_render($alt_tag);
              }

              // Grab the photo credit.
              $credit = field_get_items('file', $entity, 'field_photo_credit');
              if ($credit) {
                $credit = field_view_value('file', $entity, 'field_photo_credit', $credit[0]);
                $credit = drupal_render($credit);
              }

              // Check the uri.
              if ($field_info[$field]['settings']['file_directory'] == 'photo-content-area') {
                $info = image_get_info($entity->uri);
                $image = theme('image_style', array(
                  'style_name' => 'photo_content_area_image',
                  'path' => $entity->uri,
                  'width' => $info['width'],
                  'height' => $info['height'],
                  'alt' => t($alt_tag),
                ));
              } else if ($field_info[$field]['settings']['file_directory'] == 'hero-photos') {
                $info = image_get_info($entity->uri);
                $image = theme('image_style', array(
                  'style_name' => 'hero_photo_image',
                  'path' => $entity->uri,
                  'width' => $info['width'],
                  'height' => $info['height'],
                  'alt' => t($alt_tag),
                ));
              } else {
                $image = theme('image', array(
                  'path' => $entity->uri,
                  'alt' => ($alt_tag) ? t($alt_tag) : NULL,
                ));
              }

              // Build the image.
              $value[] = array(
                'image' => array(
                  '#markup' => $image,
                  '#access' => TRUE,
                ),
                'credit' => array(
                  '#markup' => $credit,
                  '#access' => TRUE,
                ),
              );

              break;

            case 'field_date':
              // If we're setting a format type, reformat to strip out invalid
              // RDF tags.
              if (isset($view['settings']['format_type'])) {
                $format = $view['settings']['format_type'];

                // Attach the value.
                $value[] = array(
                  '#markup' => '<time datetime="' . $item['value'] . '">' . format_date(strtotime($item['value']), $format) . '</time>',
                  '#access' => field_access('view', $field_info[$field], 'node')
                );
              } else {
                // Use a default viewer.
                $value[] = field_view_value(FORTY_ACRES_FIELD_COLLECTION_ITEM_ENTITY_TYPE, $collection, $field, $item, $view);
              }
              break;

            // Display the default view for the field type.
            default:
              $value[] = field_view_value(FORTY_ACRES_FIELD_COLLECTION_ITEM_ENTITY_TYPE, $collection, $field, $item, $view);
              break;
          }
        }
      }

      // Associate for the field.
      $temp[$field] = $value;
    }

    // Assign back to the array.
    $variables['values'] = $temp;
  }
}

/**
 * Implements theme_preprocess_field(). Renames the default classes for the
 * field name to match the front-end template styles.
 */
function phase2_theme1_preprocess_field(&$variables) {
  // Compress the class array.
  $variables['classes_array'] = array(
    'field',
    str_replace('-', '_', $variables['field_name_css'])
  );
  if ($variables['element']['#field_name'] == 'field_utexas_call_to_action') {
    $url = $variables['items'][0]['#element']['url'];
    $title = $variables['items'][0]['#element']['title'];
    $attributes = $variables['items'][0]['#element']['attributes'];
    $variables['rendered_link'] = l('<span>' . $title . '</span>', $url, array('html' => TRUE, 'attributes' => $attributes));
  }
}

/**
 * Implements template_preprocess_field_collection_view(). Used to add a theme
 * hook suggestion for further templating.
 *
 * @see template_preprocess_field_collection_view().
 */
function phase2_theme1_preprocess_field_collection_view(&$variables) {
  // Remove the links on the individual field collection.
  unset($variables['element']['links']);

  // Add a custom template file for field collection views.
  $variables['theme_hook_suggestions'][] = 'field_collection_view';
}

/**
 * Template preprocessor for theme('html'). Attaches new metatags for the
 * different favicons and touch icons.
 *
 * @see drupal_add_html_head().
 */
function phase2_theme1_preprocess_html(&$variables) {
  // Attach favicons to the page.
  $path = base_path() . drupal_get_path('theme', 'phase2_theme1') . '/img/favicon/';
  $apple_icons = array('', '57x57','60x60', '72x72', '76x76', '114x114', '120x120', '144x144', '152x152', '180x180');
  foreach ($apple_icons as $size) {
    if ($size) {
      // There's a size, so attach that as an extension.
      drupal_add_html_head(array(
        '#tag' => 'link',
        '#attributes' => array(
          'rel' => 'apple-touch-icon',
          'sizes' => $size,
          'href' => $path . 'apple-touch-icon-' . $size . '.png',
        ),
      ), 'apple-touch-' . $size);
    } else {
      // This is the default icon, so attach that.
      drupal_add_html_head(array(
        '#tag' => 'link',
        '#attributes' => array(
          'rel' => 'apple-touch-icon',
          'href' => $path . 'apple-touch-icon.png',
        ),
      ), 'apple-touch');
    }
  }

  // Attach favicon
  drupal_add_html_head(array(
    '#tag' => 'link',
    '#attributes' => array(
      'rel' => 'icon',
      'href' => $path . 'favicon.ico',
    ),
  ), 'favicon-png');

  // Set the IE 6-9 favicon. IE10 defaults to /favicon.ico.
  drupal_add_html_head(array(
    '#tag' => 'link',
    '#attributes' => array(
      'rel' => 'shortcut icon',
      'href' => $path . 'favicon.ico',
    ),
    '#prefix' => '<!--[if IE]>',
    '#suffix' => '<![endif]-->',
  ), 'ie-favicon');

  // Set application tiles.
  drupal_add_html_head(array(
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'msapplication-TileColor',
      'content' => '#bf5700',
    ),
  ), 'msapplication-TileColor');
  drupal_add_html_head(array(
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'msapplication-TileImage',
      'content' => $path . 'apple-touch-icon-144x144.png',
    ),
  ), 'msapplication-TileImage');


  // Add viewport.
  drupal_add_html_head(array(
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'viewport',
      'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no',
    ),
  ), 'meta-viewport');

  // Add a custom title for Apple homescreen users.
  drupal_add_html_head(array(
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'apple-mobile-web-app-title',
      'content' => t('UT Austin'),
    ),
  ), 'apple-mobile-web-app-title');
}

/**
 * Preprocessor for page.tpl.php. Adds in new stylesheets for base, core home,
 * core pages. Also handles adding new javascript, and setting page theme
 * suggestions based on the field_template value. It also throws the menus into
 * a variable on the $page array, and defines the partials directory.
 *
 * Finally, it associates the 404 and 403 pages with their theme suggestions.
 */
function phase2_theme1_preprocess_page(&$variables, $hook) {
  $path = drupal_get_path('theme', 'phase2_theme1');



  // Modernizr is important to prevent flash of unstyled content, so put that
  // in the header.
  drupal_add_js($path . '/js/modernizr.min.js', array('scope' => 'head_scripts', 'weight' => -1, ));

  // Add all secondary scripts to the footer for faster page loading.
  drupal_add_js($path . '/js/jquery.plugins.min.js', array('scope' => 'foot_scripts', 'weight' => 0, ));
  drupal_add_js($path . '/js/foundation.min.js', array('scope' => 'foot_scripts', 'weight' => 0, ));
  drupal_add_js($path . '/js/application.min.js', array('scope' => 'foot_scripts', 'weight' => 5, ));

  // Make sure we're only doing these actions on a noad page.
  if (isset($variables['node'])) {
    // If we're on a node page, grab the object for use later.
    $node = $variables['node'];

    // If the node type is a page, add extra theme wrappers.
    if ($node->type == 'page') {
      // Grab a taxonomy term for this page node.
      if ($template = field_get_items('node', $node, 'field_template')) {
        $template = taxonomy_term_load($template[0]['tid']);

        // Save the term for later use.
        $term = $template;

        // Use the loaded taxonomy term to attach a theme hook suggestion.
        $vocabulary = $template->vocabulary_machine_name;
        $template   = str_replace('.tpl.php', '', str_replace('-', '_', $template->additional_settings['template_file']));

        // Attach new theme hook suggestions.
        $old_suggestions = $variables['theme_hook_suggestions'];
        $new_suggestions = array('page__' . $vocabulary, $template);
        $variables['theme_hook_suggestions'] = array_merge($new_suggestions, $old_suggestions);

        // Strip out the node wildcard, just in case.
        if ($wildcard_key = array_search('page__node__%', $variables['theme_hook_suggestions'])) {
          unset($variables['theme_hook_suggestions'][$wildcard_key]);
        }

        // Get a listing of all fields that we've set as locked to the template
        // for this template choice.
        $variables['locked_fields'] = array();
        $fields = array();
        if (isset($term->additional_settings['fields'])) {
          foreach ($term->additional_settings['fields'] as $field) {
            if ($field['enabled'] and $field['locked']) {
              $fields[] = $field['machine_name'];
            }
          }
        }

        // Attach locked fields to the page variables.
        foreach ($fields as $field_name) {
          $values = array();
          if ($items = field_get_items('node', $node, $field_name, $node->language)) {
            foreach ($items as &$item) {
              $values[] = field_view_value('node', $node, $field_name, $item, $node->language);
            }

            // Wrap the field in it's class name.
            $values['#prefix'] = '<div class="' . $field_name . '">';
            $values['#suffix'] = '</div>';

            $variables['locked_fields'][$field_name] = $values;
          }
        }
      }
    }
  }

  // Get easily accessible menus into the page variable.
  $variables['page']['menus'] = array(
    'core_directory' => menu_tree('menu-directory'),
    'core_footer' => menu_tree('menu-footer'),
    'core_personas' => menu_tree('menu-persona'),
    'core_secondary' => menu_tree('menu-secondary-navigation'),
    'core_main' => module_invoke('utexas_menu', 'block_view', 'utexas_main_menu')['content'],
    'core_helpful_links' => menu_tree('menu-core-helpful-links'),
  );

  // Set a partials directory for use on the template tpl pages.
  $variables['partials_dir'] = __DIR__ . '/templates/partials/';

  // Figure out if we're on a 403 or 404 page.
  if ($header = drupal_get_http_header('status')) {
    switch ($header) {
      case '403 Forbidden':
        // Set the page template for 403 page.
        $variables['theme_hook_suggestions'][] = 'page__page_403';
        break;

      case '404 Not Found':
      default:
        // Set the page template for 404 page.
        $variables['theme_hook_suggestions'][] = 'page__page_404';
        break;
    }
  }
  // Building the 404 drupal search form
  $search_form = drupal_get_form('search_block_form');
  $form_build_id = '';
  $form_token = '';
  if(!empty($search_form['form_build_id']['#value'])){
    $form_build_id = $search_form['form_build_id']['#value'];
  }
  if(!empty($search_form['form_token']['#default_value'])){
    $form_token = $search_form['form_token']['#default_value'];
  }
  $placeholder = get_current_search_terms();
  //Google custom search bars
  global $base_url;
  $google_logo = $base_url . '/sites/all/themes/utexas_news/img/general/google-logo.png';
  $variables['search_cse'] = "
  <label for='search-desktop' class='hiddenText'>Search UT Austin News</label>
  <form action='//www.utexas.edu/search/results.php' method='get' id='cse_searchbox'>
    <input type='hidden' name='cx' value='006470498568929423894:etsxpcor8wm' />
    <input type='hidden' name='cof' value='FORID:10' />
    <input type='text' name='q' id='search-desktop' placeholder='" . $placeholder . "' class='search-page-input' title='Search the University of Texas site' aria-labelledby='desktopSearchLabel'>
    <button class='nav-search-button'><span class='hiddenText'>Search</span><span class='icon-search'></span></button>
  </form>
  <p class='custom-search'>
    <img src='" . $google_logo . "'>
    Custom Search
  </p>";

  $variables['header_search_cse'] = "
  <form action='//www.utexas.edu/search/results.php' method='get' id='cse_searchbox'>
    <input type='hidden' name='cx' value='006470498568929423894:etsxpcor8wm' />
    <input type='hidden' name='cof' value='FORID:10' />
    <input type='text' name='q' id='search-desktop' placeholder='Search' class='nav-search-input' title='Search the University of Texas site' aria-labelledby='desktopSearchLabel'>
    <button class='nav-search-button'><span class='hiddenText'>Search</span><span class='icon-search'></span></button>
  </form>";

  // Random off-chance that the user reaches page/404 or page/403, return
  // content for those as well.
  if (arg(0) == 'page') {
    if (arg(1) == '404') {
      $variables['theme_hook_suggestions'][] = 'page__page_404';
    }
    if (arg(1) == '403') {
      $variables['theme_hook_suggestions'][] = 'page__page_403';
    }
  }
  // set the font of the topnav bar from the theme settings
  $font = theme_get_setting('main_menu_font');
  drupal_add_css('#main-nav li a { font-family:' . $font . ';}', 'inline');

  // set the secondary logo
  $secondary_logo = theme_get_setting('choose_secondary_logo');
  if ($secondary_logo == 'large_horizontal_logo'){
    $logo_class = 'long_logo';
  }
  elseif ($secondary_logo == 'small_texas_logo'){
    $logo_class = 'short_logo';
  }
  else {
    $logo_class = 'knockout_logo';
  }
  $variables['branded_logo_class'] = $logo_class;

  $variables['newsletter_display'] = theme_get_setting('newsletter_url');
  $variables['footer_text'] = theme_get_setting('footer_text_area');
  $variables['display_social'] = theme_get_setting('display_social_icons');
  $variables['display_persona_menu'] = theme_get_setting('secondary_menu');
  $variables['tertiary_logo_link'] = theme_get_setting('tertiary_logo_link');
  // manage image files uploaded through theme
  $fid = theme_get_setting('tertiary_logo');
  //$variables['tertiary_logo_url'] = file_create_url(file_load($fid)->uri);
  $variables['tertiary_logo_url'] = false;
  $variables['tertiary_logo'] = false;
  $variables['tertiary_logo_title'] = false;
  if (isset($fid)) {
    if ($fid != 0) {
      $variables['tertiary_logo_url'] = ($file = file_load($fid)) ? file_create_url($file->uri) : false;
      if ($variables['tertiary_logo_url'] != false) {
        $image = array(
          'path' => $variables['tertiary_logo_url'],
          'alt' => 'Logo',
          'title' => '',
          'attributes' => '',
        );
      }
      if (($variables['tertiary_logo_url'] != false) and ($variables['tertiary_logo_link'] != '')) {
        $variables['tertiary_logo'] = '<h2 class="UT-tertiary-logo">' .
        l(theme_image($image), $variables['tertiary_logo_link'] , array('html' => TRUE, 'external' => true)) . '</h2>';
        $variables['tertiary_logo_title'] = theme_get_setting('tertiary_logo_title');
      }
      elseif (isset($variables['tertiary_logo_url'])) {
        $variables['tertiary_logo'] = '<h2 class="UT-tertiary-logo">' . theme_image($image) . '</h2>';
      }
    }
  }
  $variables['newsletter_exists'] = theme_get_setting('newsletter_exists');
  $variables['newsletter_url'] = theme_get_setting('newsletter_url');
  $variables['hide_homepage_title'] = '';
  if (drupal_is_front_page()) {
    $variables['hide_homepage_title'] = 'hiddenText';
    drupal_add_css('.UT-page { margin-top:50px;}','inline');
  }

  if (variable_get('utexas_google_tag_manager_gtm_verification', '') != '') {
    // Add Google verification metatag to all pages
    $element = array(
      '#tag' => 'meta',
      '#attributes' => array(
        'name' => 'google-site-verification',
        'content' => variable_get('utexas_google_tag_manager_gtm_verification', ''),
      ),
    );
    drupal_add_html_head($element, 'google-site-verification');
  }
}

/**
 * Process variables for html.tpl.php. Adds header and footer scripts.
 */
function phase2_theme1_process_html(&$variables) {
  // Separate scripts into head_scripts and foot_scripts.
  $variables['head_scripts'] = drupal_get_js('head_scripts');
  $variables['foot_scripts'] = drupal_get_js('foot_scripts');
}

/**
 * Implements hook_form_alter
 */
function phase2_theme1_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_form') {
    // Hide the default search form in favor of our custom one; see $search_form
    $form['#access'] = FALSE;
  }
}

/**
 * Helper function to retrieve search terms in URL for search form placeholder
 */
function get_current_search_terms() {
// only do this once per request
static $return;
    if (!isset($return)) {
        // extract keys from path
        $path = explode('/', $_GET['q'], 3);
        // only if the path is search (if you have a different search url, please modify)
        if(count($path) == 3 && $path[0]=="search") {
            $return = $path[2];
        } else {
            $keys = empty($_REQUEST['keys']) ? 'Search' : $_REQUEST['keys'];
            $return = $keys;
        }
    }
    return $return;
}
