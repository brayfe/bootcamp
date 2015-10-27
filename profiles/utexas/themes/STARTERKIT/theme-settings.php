<?php
/**
 * @file
 * Theme settings which allow for configuration settings through the theme UI.
 */

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function STARTERKIT_form_system_theme_settings_alter(&$form, &$form_state) {

  // Main navigation settings.
  $form['utexas_main_nav_theme_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Main navigation bar settings'),
  );
  $form['utexas_main_nav_theme_settings']['choose_secondary_logo'] = array(
    '#type' => 'radios',
    '#title' => t('Choose secondary logo'),
    '#description' => t('Select an image to dislay in the right region of the burnt-orange branded bar.  This logo will link to www.utexas.edu.'),
    '#options' => array(
      'large_horizontal_logo' => t('The University of Texas at Austin'),
      'small_texas_logo' => t('Texas'),
      'texas_shield' => t('Texas with shield'),
    ),
    '#default_value' => theme_get_setting('choose_secondary_logo'),
  );
  $form['utexas_main_nav_theme_settings']['tertiary_logo'] = array(
    '#title' => t('Tertiary logo'),
    '#description' => t('Upload a logo to display in the left region of the burnt-orange branded bar, above the main image. Ideal for lengthwise wordmarks, as it displays at 25 pixels in height.'),
    '#type' => 'managed_file',
    '#upload_location' => 'public://tertiary-logo/',
    '#upload_validators' => array(
      'file_validate_extensions' => array('png svg'),
    ),
    '#default_value' => theme_get_setting('tertiary_logo'),
  );
  $form['utexas_main_nav_theme_settings']['tertiary_logo_link'] = array(
    '#type' => 'textfield',
    '#title' => t('Tertiary logo link'),
    '#description' => t('Optionally, set the tertiary logo to link to a URL of your choice.'),
    '#default_value' => theme_get_setting('tertiary_logo_link'),
    '#attributes'    => array(
      'placeholder' => t('http://'),
    ),
  );
  $form['utexas_main_nav_theme_settings']['tertiary_logo_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Tertiary logo title'),
    '#description' => t('Enter a title for the tertiary logo if you would like it to appear in the mobile navigation menu. Please note that a logo must be uploaded for the title to appear in the mobile navigation menu.'),
    '#default_value' => theme_get_setting('tertiary_logo_title'),
  );
  $form['utexas_main_nav_theme_settings']['main_nav_settings'] = array();
  $form['utexas_main_nav_theme_settings']['secondary_menu'] = array(
    '#type' => 'radios',
    '#title' => t('Display header menu or social links in the secondary menu?'),
    '#options' => array(
      'social_links' => t('Social links'),
      'header_menu' => t('Header menu'),
    ),
    '#default_value' => theme_get_setting('secondary_menu'),
  );
  $form['utexas_main_nav_theme_settings']['main_menu_font'] = array(
    '#type' => 'radios',
    '#title' => t('Select font for main menu'),
    '#options' => array(
      'charissilw' => t('Serif'),
      'open_sans' => t('Sans-serif'),
    ),
    '#default_value' => theme_get_setting('main_menu_font'),
  );

  // Footer settings.
  $form['utexas_footer_theme_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Footer settings'),
  );
  $form['utexas_footer_theme_settings']['footer_text_area'] = array(
    '#type' => 'textarea',
    '#title' => t('Enter the text for footer'),
    '#default_value' => theme_get_setting('footer_text_area'),
  );
  $form['utexas_footer_theme_settings']['display_social_icons'] = array(
    '#type' => 'checkbox',
    '#title' => t('Would you like to display social links in the footer?'),
    '#default_value' => theme_get_setting('display_social_icons'),
  );
  $form['utexas_footer_theme_settings']['newsletter_exists'] = array(
    '#type' => 'checkbox',
    '#title' => t('Do you have a newsletter?'),
    '#default_value' => theme_get_setting('newsletter_exists'),
  );
  $form['utexas_footer_theme_settings']['newsletter_container'] = array(
    '#type' => 'container',
    '#states' => array(
      'invisible' => array(
        'input[name="newsletter_exists"]' => array('checked' => FALSE),
      ),
    ),
  );
  $form['utexas_footer_theme_settings']['newsletter_container']['newsletter_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Enter the newsletter url here.'),
    '#default_value' => theme_get_setting('newsletter_url'),
  );

}
/**
 * Form submission handler for system_settings_form().
 *
 * If you want node type configure style handling of your checkboxes,
 * add an array_filter value to your form.
 */
function STARTERKIT_settings_form_submit(&$form, $form_state) {
  $image_fid = $form_state['values']['tertiary_logo'];
  $image = file_load($image_fid);
  if (is_object($image)) {
    // Check to make sure that the file is set to be permanent.
    if ($image->status == 0) {
      // Update the status.
      $image->status = FILE_STATUS_PERMANENT;
      // Save the update.
      file_save($image);
      // Add a reference to prevent warnings.
      file_usage_add($image, 'STARTERKIT', 'theme', 1);
    }
  }
}
