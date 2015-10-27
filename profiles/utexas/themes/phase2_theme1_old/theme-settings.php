<?php

function phase2_theme1_form_system_theme_settings_alter(&$form, &$form_state) {

  // main navigation settings
  $form['utexas_main_nav_theme_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Main navigation bar settings'),
  );
    $form['utexas_main_nav_theme_settings']['choose_secondary_logo'] = array(
      '#type' => 'radios',
      '#title' => t('Choose secondary logo'),
      '#options' => array(
        'large_horizontal_logo' => t('The University of Texas at Austin'),
        'small_texas_logo' => t('Texas'),
        'texas_shield' => t('Texas with shield'),
      ),
      '#default_value' => theme_get_setting('choose_secondary_logo'),
    );
    $form['utexas_main_nav_theme_settings']['tertiary_logo'] = array(
      '#title' => t('Tertiary logo'),
      '#description' => t('Small logo in right part of topnav bar'),
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
      '#description' => t('Optionally, make this image into a link.'),
      '#default_value' => theme_get_setting('tertiary_logo_link'),
      '#attributes'    => array(
        'placeholder' => t('http://'),
      ),
    );
    $form['utexas_main_nav_theme_settings']['tertiary_logo_title'] = array(
      '#type' => 'textfield',
      '#title' => t('Tertiary logo title'),
      '#description' => t('Title to display in mobile navigation menu.  Please note that a logo must be uploaded for the title to appear in the mobile navigation menu.'),
      '#default_value' => theme_get_setting('tertiary_logo_title'),
    );
  $form['utexas_main_nav_theme_settings']['main_nav_settings'] = array();
    $form['utexas_main_nav_theme_settings']['secondary_menu'] = array(
      '#type' => 'radios',
      '#title' => t('Display persona menu or social links in the secondary menu?'),
      '#options' => array(
        'social_links' => t('Social links'),
        'persona_menu' => t('Persona menu'),
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


  //footer settings
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

  function phase2_theme1_settings_form_submit(&$form, $form_state) {
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
        file_usage_add($image, 'phase2_theme1', 'theme', 1);
      }
    }
  }
