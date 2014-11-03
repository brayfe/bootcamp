UTLogin
=======
Allows Drupal to authenticate users via the centralized authentication service,
UTLogin (http://www.utexas.edu/its/utlogin). Users who have existing UTLogin sessions
will be considered authenticated when visiting the Drupal site. Users without
active UTLogin sessions will be redirected to the UTLogin sign-in page.

Features
--------
 - Convert users to UTLogin individually or in bulk
 - Enable automatic user account creation for visitors with active UTLogin sessions
   who don’t have a Drupal account
 - Set the post-logout URL location
 - Update account email addresses from current UTLogin data
 - Revert users to non-UTLogin authentication gracefully by disabling the module

Requirements
------------
 - UT Web Policy Agent (v3.3.3 or higher) configured for use with UTLogin and
   Drupal (see installation steps, below)
 - Drupal 7.x http://drupal.org/project/drupal
 - Browser: A recent version of Safari, Chrome, Internet Explorer, or Firefox;
   must be configured to accept cookies. See http://www.utexas.edu/about-this-site/web-browsers

Dependencies
------------
 - CTools
 - Entity API
 - Views
 - Views Bulk Operations

Installation
------------
1. Fill out a UTLogin Drupal Configuration Request:
https://utexas.qualtrics.com/SE/?SID=SV_4HLrQLayByxPaHX
This provides customized guidance on setting up your Web Policy Agent (WPA) and
Realm Policy Manager (RPM). Configuration depends on whether your site is on
UTWeb and whether you already have a WPA on your server. For more information
about the UTLogin WPA, see http://www.utexas.edu/its/utlogin.

2. Place this module in your modules directory, either via FTP or by uploading
the zipped file via admin/modules/install. IMPORTANT: Before enabling, see
Configuration step 1.

Configuration
-------------
1. Ensure that all users you plan to convert to UTLogin authentication have
usernames that match their EIDs. Once the module is enabled, usernames cannot be
edited. UID 1 is the exception, since it will not use UTLogin.

2. Enable the module (at admin/modules or via "drush en utlogin"). Enabling the
module does NOT automatically convert existing accounts to UTLogin. Once
enabled, however, a few standard Drupal behaviors change:
 - Accounts not designated for UTLogin authentication will not be able to log in
   (excepting UID 1)
 - New accounts will automatically use UTLogin
 - The default Drupal login block becomes disabled (the /user login page is
   still available)
 - The password reset form (/user/password) is disabled except for UID 1

3. Choose which accounts should use UTLogin authentication at
/admin/config/people/utlogin/convert-users. This page lists all users who are
eligible for UTLogin conversion.

4. Configure options at /admin/config/people/utlogin
 - Whether to automatically register new users with UTLogin headers. EID is
   mapped to $user->name.
 - The location users should be redirected to after logging out. Both internal
   paths (e.g. "<front>" or "node/23") and absolute URLs (e.g.
   "http://example.utexas.edu/node/23") are acceptable, however, if an external
   URL is used, it must be in a .utexas.edu domain or be whitelisted by the
   IAM/UTLogin team for redirection. See https://www.utexas.edu/its/help/utlogin/2377

5. (Optional) Position the UTLogin block on your site (admin/structure/block/).
Any links to /user/login or /user/logout will automatically redirect to
UTLogin, while /user remains for non-UTLogin authentication.

6. (Optional) Define Drupal role permissions:
 - "Administer the UTLogin Module" (under "UTLogin"): can configure the UTLogin
   module settings.
 - "Execute Convert local users to UTLogin users" (available if "Actions
   permissions (VBO) is enabled"): can convert users to UTLogin


Disable & Uninstall
-------------------
Disable the module (at admin/modules or via "drush dis utlogin") to revert
all user accounts to non-UTLogin (Drupal) authentication.
 - Accounts that existed prior to UTLogin being enabled retain their original
   passwords.
 - Accounts created while UTLogin was enabled will have been assigned a random
   password, which individual users can reset (user/password).

Disabling the module does NOT remove database entries indicating which users
have been converted to UTLogin authentication, so re-enabling the module will
reinstate users who have already been converted to UTLogin. To remove the
database entries, disable the module, then uninstall it at admin/modules/uninstall.

Notes
-----
 - Drupal 7.12 and prior may not properly handle email notifications to users
   without email addresses, resulting in the administrator receiving an Internal
   Server Error.

 - A conflict can arise that hampers editing the UID 1 profile form: if the
   administrator's email address is his/her main UT Austin email, and the
   administrator subsequently creates an EID-based account, UTLogin will
   automatically populate it with the same UT email address, resulting in two
   Drupal accounts with the same email. Drupal is designed to throw a
   validation error in this case and prevent form submission. To avoid this,
   assign the administrator a different email, or simply don't create an EID
   account that will conflict.


Support
-------
This module was developed by the University of Texas ITS Web and Contract
Services Team. For questions or support, email help@its.utexas.edu.
