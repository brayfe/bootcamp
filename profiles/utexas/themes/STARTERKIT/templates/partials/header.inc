<?php
/**
 * @file
 * Partial file to display the site header.
 */

?>
  <header class="UT-header theme1">
    <div class="container container-logo-p2">
      <div class="row">
        <div class="column small-12">
<?php
if ($logo) :
  ?>
            <div class="p2-logo">
              <a href="<?php print $base_path; ?>" class="main-logo"><span class="hiddenText"><?php print $site_name; ?></span><img class="main_logo" src="<?php print $logo; ?>" alt="main_logo">
              </a>
            </div>
  <?php
endif;
  ?>
        </div>
      </div>
      <a href="#" class="UT-nav-hamburger icon-menu" id="menu-icon"><span class="hiddenText">Menu</span></a>
    </div> <!-- container-logo -->

    <div class="nav-overlay" id="nav-overlay"></div>
    <div class="nav-wrapper" role="navigation">

      <div class="container container-topnav">
        <div class="row">
          <div class="column small-12">
            <div class="topnav <?php print $branded_logo_class; ?>">

              <div class="parent-banner-links">
                <h2 class="UT-secondary-logo">
                  <a href="http://www.utexas.edu" class="logo-link"><span class="hiddenText">UTexas Home</span></a>
                </h2>
<?php
if ($tertiary_logo != FALSE) :
  echo $tertiary_logo;
endif;
  ?>
              </div>

              <div class="hide-for-large-up">
                <div class="parent-links" id="parents">
                  <a href="http://www.utexas.edu">The University of Texas at Austin</a>
  <?php
if ($tertiary_logo_title != FALSE) :
  ?>
                    <a href="<?php print $tertiary_logo_link; ?>"><?php echo $tertiary_logo_title; ?></a>
  <?php
endif;
  ?>
                </div>

  <?php
if ($site_name) :
  ?>
                  <a href="<?php print $base_path; ?>" class="current-directory" id="show-parents"><span class="name"><?php print $site_name; ?></span><span class="toggle"></span></a>
  <?php
else :
  ?>
                  <a href="<?php print $base_path; ?>" class="current-directory" id="show-parents"><span class="name">Home</span><span class="toggle"></span></a>
  <?php
endif;
  ?>
              </div>

              <div class="nav-item-search show-for-large-up">
<?php
if ($display_header_menu == 'header_menu') {
  print render($page['menus']['header']);
}
else {
  $block = block_load('utexas_partials_social_links', 'social_links_block');
  $render_array = _block_get_renderable_array(_block_render_blocks(array($block)));
  $output = $render_array['utexas_partials_social_links_social_links_block']["content"]["#markup"];
  print $output;
}
if (isset($header_search_cse)) :
  print render($header_search_cse);
endif;
  ?>
              </div>

              <ul class="topnav-links hide-for-large-up">
                <li class="nav-item nav-item-search">
  <?php
if (isset($header_search_cse)) :
  print render($header_search_cse);
endif;
  ?>
                </li>
              </ul>

            </div>
          </div>
        </div>
      </div> <!-- container-topnav -->

      <div class="container container-nav container-nav-phase2">
        <div class="row">
          <div class="column small-12">
            <nav>
              <?php print render($page['menus']['core_main']); ?>
            </nav>
          </div>
        </div>
      </div> <!-- container-nav-phase2 -->

    </div> <!-- nav-wrapper -->

  </header><!-- /header -->
