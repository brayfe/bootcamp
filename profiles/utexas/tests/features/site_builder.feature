# features/site_builder.feature

@api
Feature: Site Builder
  In order to build sites
  As a site builder
  I need to be able to perform the tasks associated with site-building

@javascript
Scenario: Perform actions with site-builder permissions

  # Validate login
  Given I am logged in as a user with the "site builder, standard page editor, landing page editor" role
  When I go to "node/add/standard-page"
  Then I should see the css element ".toolbar-menu"
  And I set browser window size to "1200" x "900"

  # Create page
  And I go to "/admin/content"
  And I click "Add content"
  And I click "Standard Page"
  Then I should see the text "Create Standard Page" in the "branding" region
  And I fill in "Standard Page Test" for "edit-title" in the "form_item_title" region
  # Add hero image
  And I click "Browse"
  And I switch to the iframe "mediaBrowser"
  And I attach the file "placeholder.jpg" to "files[upload]"
  And I press the "Next" button
  And I press the "Save" button
  And I press the "Save" button
  Then I should see the message "Standard Page Standard Page Test has been created."

  # Create block
  When I go to "/admin/structure/block/add"
  And I fill in "Test Block" for "Block title"
  And I fill in "Test Block" for "Block description"
  And I select "Plain text" from "Text format"
  And I fill in "Cat ipsum dolor sit amet, give attitude for spread kitty litter all over house. Hack up furballs stare at the wall, play with food and get confused by dust and mew attack feet run in circles. Caticus cuteicus paw at your fat belly yet missing until dinner time, or sit by the fire." for "Block body"
  And I click on the element "#edit-submit"
  And I click "Home"

  # Use the layout editor to place a block
  And I click "Layout Editor" in the "primary_tabs" region
  And I click "Edit" in the "context_editor" region
  And I wait for css element ".main-content" to "appear"
  And I click on the element ".context-ui-add-link.context-ui-processed" in the "#context-block-region-main_content_top_left" region
  And I click on the element "#context-block-addable-block-1"
  And I wait for css element "#block-block-1" to "appear"
  And I click "Done" in the "context_editor" region
  And I press the "Save" button
  # test for custom block prescence on page
  Then I should see the text "Cat ipsum dolor sit amet, give attitude for spread kitty litter all over house. Hack up furballs stare at the wall, play with food and get confused by dust and mew attack feet run in circles. Caticus cuteicus paw at your fat belly yet missing until dinner time, or sit by the fire." in the "top_left_region" region

  # Administer theme settings
  When I go to "/admin/appearance/settings/forty_acres"
  When I select the radio button "Tall"
  And I fill in "School of Hard Knocks" for "Parent Entity Name"
  And I fill in "http://www.google.com" for "Parent Entity Website"
  And I fill in "Cat ipsum dolor sit amet, give attitude for spread kitty litter all over house. Hack up furballs stare at the wall, play with food and get confused by dust and mew attack feet run in circles. Caticus cuteicus paw at your fat belly yet missing until dinner time, or sit by the fire." for "OPTIONAL - Enter text to be displayed in a block in the left-most region of the footer."
  And I check the box "newsletter_exists"
  And I fill in "http://www.google.com" for "Enter the URL of your newsletter subscription form."
  And I press the "Save configuration" button
  Then I should see the message "The configuration options have been saved."
  And I click "Home"
  Then I should see "School of Hard Knocks" in the "header" region
  Then I should see "Cat ipsum dolor sit amet, give attitude for spread kitty litter all over house. Hack up furballs stare at the wall, play with food and get confused by dust and mew attack feet run in circles. Caticus cuteicus paw at your fat belly yet missing until dinner time, or sit by the fire." in the "full_page_content" region
  Then I should see "Subscribe to our newsletter" in the "full_page_content" region

  # Verify Site Builder can access designated configuration pages
  When I go to "/admin/config/utexas/google_cse"
  Then I should see "The Google Custom Search Engine ID sets which domains the site searches. Create a targeted search criteria at https://cse.google.com/." in the "page" region
  When I go to "/admin/config/utexas/twitter"
  Then I should see "Assign the Twitter App for this site. To register a new App, go to the Twitter App page." in the "page" region
  When I go to "/admin/config/system/utexas_google_tag_manager"
  Then I should see "What is your Google Tag Manager account code? It usually is a six digit code, prefixed with GTM." in the "page" region

  # Verify Site Builder can not access designated configuration pages
  When I go to "/admin/config/system/cron"
  Then I should see "You are not authorized to access this page." in the "page" region
  When I go to "/admin/structure/views"
  Then I should see "You are not authorized to access this page." in the "page" region
  When I go to "/admin/people/permissions"
  Then I should see "You are not authorized to access this page." in the "page" region
  When I go to "/admin/modules"
  Then I should see "You are not authorized to access this page." in the "page" region
  When I go to "/admin/appearance/settings/bartik"
  Then I should see "You are not authorized to access this page." in the "page" region

  # Switch themes and edit theme-settings with 'access all themes' permission
  Given I am logged in as a user with the "access all themes,view the administration theme" permission on this site
  When I go to "/admin/appearance/settings/starterkit"
  When I select the radio button "Tall"
  And I fill in "School of Hard Knocks" for "Parent Entity Name"
  And I fill in "http://www.google.com" for "Parent Entity Website"
  And I fill in "Cat ipsum dolor sit amet, give attitude for spread kitty litter all over house. Hack up furballs stare at the wall, play with food and get confused by dust and mew attack feet run in circles. Caticus cuteicus paw at your fat belly yet missing until dinner time, or sit by the fire." for "OPTIONAL - Enter text to be displayed in a block in the left-most region of the footer."
  And I check the box "newsletter_exists"
  And I fill in "http://www.google.com" for "Enter the URL of your newsletter subscription form."
  And I press the "Save configuration" button
  Then I should see the message "The configuration options have been saved."
  And I click "Home"
  Then I should see "School of Hard Knocks" in the "header" region
  Then I should see "Cat ipsum dolor sit amet, give attitude for spread kitty litter all over house. Hack up furballs stare at the wall, play with food and get confused by dust and mew attack feet run in circles. Caticus cuteicus paw at your fat belly yet missing until dinner time, or sit by the fire." in the "full_page_content" region
  Then I should see "Subscribe to our newsletter" in the "full_page_content" region
  When I go to "/admin/appearance/settings/bartik"
  Then I should see "These options control the display settings for the Bartik theme. When your site is displayed using this theme, these settings will be used." in the "page" region
