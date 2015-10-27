## Run CodeSniffer on selected files/directories. Commented out items
# include style "violations" that are needed but are erroneously flagged by
# phpcs version 1.5.x

# Installation profile
drush drupalcs ../utexas.profile
drush drupalcs ../utexas.install
drush drupalcs ../utexas.css
drush drupalcs ../default_content/default_basic_page.inc
# drush drupalcs ../default_content/default_page.inc
# drush drupalcs ../default_content/landing_page.inc

# Themes
drush drupalcs ../themes/forty_acres/template.php
drush drupalcs ../themes/forty_acres/theme-settings.php
drush drupalcs ../themes/forty_acres/templates
drush drupalcs ../themes/STARTERKIT/template.php
drush drupalcs ../themes/STARTERKIT/theme-settings.php
drush drupalcs ../themes/STARTERKIT/templates

# Modules
drush drupalcs ../modules/custom/utexas_devel/utexas_devel.module
# drush drupalcs ../modules/custom/utexas_devel/utexas_devel.install
drush drupalcs ../modules/custom/utexas_google_cse
drush drupalcs ../modules/custom/utexas_google_tag_manager
drush drupalcs ../modules/custom/utexas_menu
drush drupalcs ../modules/custom/utexas_page_builder
drush drupalcs ../modules/custom/utexas_partials_social_links
drush drupalcs ../modules/custom/utexas_tablesaw_filter
drush drupalcs ../modules/custom/utexas_admin
# drush drupalcs ../modules/custom/features/content_types/faculty_profile/faculty_profile.module
drush drupalcs ../modules/custom/features/content_types/faculty_profile/faculty_profile.install
drush drupalcs ../modules/custom/features/content_types/faculty_profile/page_layout/page--faculty-profile.tpl.php

# Tests
drush drupalcs credentials.php
# drush drupalcs features/bootstrap/FeatureContext.php
