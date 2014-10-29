<?php

/**
 * @file
 * The admin file for the UTLogin module.
 */

/**
 * Form constructor for the UTLogin settings.
 *
 * @see system_settings_form()
 */
function utlogin_admin_form() {
  $form = array();

  // Enable or disable auto-registering new users with UTLogin headers.
  $form['utlogin_auto_register'] = array(
    '#type' => 'checkbox',
    '#title' => t('Auto-register new UTLogin users'),
    '#default_value' => variable_get('utlogin_auto_register', 0),
    '#description' => t('Automatically register new users with UTLogin headers.  EID is mapped to $user->name.'),
    '#required' => FALSE,
  );

  // Set the default location users should be redirected to after logout.
  $form['utlogin_logout_goto'] = array(
    '#type' => 'textfield',
    '#title' => t('Destination after logout'),
    '#default_value' => variable_get('utlogin_logout_goto', url(NULL, array('absolute' => TRUE))),
    '#description' => t('The location users should be redirected to after logging out.  Both internal paths and absolute URLs are acceptable.  If an external URL is specified, it must be in a .utexas.edu domain or be whitelisted by the IAM/UTLogin team for redirection.'),
    '#required' => FALSE,
  );

  return system_settings_form($form);
}
