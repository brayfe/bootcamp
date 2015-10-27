<?php
/**
 * @file
 * Theme settings which allow for configuration settings through the theme UI.
 */

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function forty_acres_form_system_theme_settings_alter(&$form, &$form_state) {

  // Disable the Toggle Display section.
  unset($form['theme_settings']);

  // Main navigation settings.
  $form['utexas_main_nav_theme_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Header settings'),
  );
  $form['utexas_main_nav_theme_settings']['logo_height'] = array(
    '#type' => 'radios',
    '#title' => 'Logo Height',
    '#description' => 'Set to Tall for logo to display at height of 100px or Short for height of 60px.',
    '#options' => array(
      'short_logo' => t('Short'),
      'tall_logo' => t('Tall'),
    ),
    '#default_value' => theme_get_setting('logo_height'),
  );
  $form['utexas_main_nav_theme_settings']['parent_link_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Parent Entity Name'),
    '#description' => t("The site's parental college or office. This will display at the left of the University brand bar."),
    '#default_value' => theme_get_setting('parent_link_title'),
  );
  $form['utexas_main_nav_theme_settings']['parent_link'] = array(
    '#type' => 'textfield',
    '#title' => t('Parent Entity Website'),
    '#description' => t("The link for the site's parental college or office.  A link is required if you have entered a Parent Entity Name."),
    '#default_value' => theme_get_setting('parent_link'),
    '#maxlength' => 256,
    '#attributes'    => array(
      'placeholder' => t('http://'),
    ),
    '#element_validate' => array('_forty_acres_parent_link_validate'),
  );

  /**
   * Helper function to provide validation on Parent Entity Website.
   */
  function _forty_acres_parent_link_validate($element, &$form_state) {
    if ($form_state['values']['parent_link_title'] != '' && empty($element['#value'])) {
      form_error($element, t('Please enter a link for the Parent Entity Website.  A link is required if you have entered a Parent Entity Name.'));
    }
    if ($element['#value'] != '' && filter_var($element['#value'], FILTER_VALIDATE_URL) === FALSE) {
      form_error($element, t('Please enter a valid link for the Parent Entity Website.'));
    }
  }

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
    '#maxlength' => 256,
  );

}
