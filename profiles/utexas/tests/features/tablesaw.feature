# features/tablesaw.feature

@api @javascript

Feature: Responsive Tablesaw behavior
  In order to make tables fully accessible
  As a site-builder
  I need to be able to place a WYSIWYG with table in a region and have it respond.

Scenario: User adds table to page
 Given I am logged in as a user with the "administrator" role on this site
 And I set browser window size to "1200" x "900"
  When I click "Add content"
  And I click "Landing Page"
  And I fill in "Tablesaw Test" for "edit-title" in the "form_item_title" region
  # Add WYSIWYG A #
  And I click on the link "WYSIWYG A" in the ".vertical-tabs-list" region
  And I the set the iframe located in element with an id of "cke_edit-field-wysiwyg-a-und-0-value" to "wysiwyg_a"
  And I fill in "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<table><thead><tr><th>Header One<th>Header Two<tbody><tr><td>Easily add tables with the WYSIWYG toolbar<td>Styled to match the brand<tr><td>Tables respond to display on smaller screens<td>Fully accessible to screen readers</table>" in WYSIWYG editor "wysiwyg_a"
  # Add UT Newsreel #
  And I click on the link "UT Newsreel" in the ".vertical-tabs-list" region
  And I fill in "Headline Text" for "edit-field-utexas-newsreel-und-0-headline"
  And I check the box "edit-field-utexas-newsreel-und-0-category-science-and-technology"
  And I fill in "View all Test" for "edit-field-utexas-newsreel-und-0-view-all"
  And I press the "Save" button
  # Assign fields to regions #
  And I wait for css element ".tabs.primary" to "appear"
  And I click "Layout Editor" in the "primary_tabs" region
  And I click "Edit" in the "context_editor" region
  And I wait for css element ".main-content" to "appear"
  # WYSIWYG A #
  And I click on the element ".context-ui-add-link.context-ui-processed" in the "#context-block-region-content_top_left" region
  And I click on the element "#context-block-addable-fieldblock-6f3b85225f51542463a88e53104f8753"
  # UT Newsreel #
  And I click on the element ".context-ui-add-link.context-ui-processed" in the "#context-block-region-content_top_right" region
  And I click on the element "#context-block-addable-fieldblock-d41b4a03ee9d7b1084986f74b617921c"
  And I wait for css element ".field.field_utexas_newsreel" to "appear"
  # Save #
  And I click "Done" in the "context_editor" region
  And I press the "Save" button
  # Verify themed output #
  Then I should see the heading "Tablesaw Test"
  And I should see "Easily add tables with the WYSIWYG toolbar" in the "wysiwyg_a_block" region
  Then I should see the "b.tablesaw-cell-label" css selector with css property "display" containing "none"
  And I set browser window size to "350" x "900"
  And I wait for 2 seconds
  Then I should see the "b.tablesaw-cell-label" css selector with css property "display" containing "block"



