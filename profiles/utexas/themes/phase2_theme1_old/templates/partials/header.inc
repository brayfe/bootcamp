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
           <div class="p2-logo">
             <a href="<?php print $base_path; ?>" class="main-logo"><span class="hiddenText"><?php print $site_name; ?></span>
              <!-- <img style="position:absolute;top:-49px;left:425px; height:22px;width:auto; " src="<?php print $base_path; ?>sites/all/themes/phase2_theme1/img/general/rgb_sansshield_office_pres_update.svg">  -->
             </a>
          </div>
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
                  if ($tertiary_logo != false) {
                    echo $tertiary_logo;
                  }
                ?>
              </div>

              <div class="hide-for-large-up">
                <div class="parent-links" id="parents">
                  <a href="http://www.utexas.edu">The University of Texas at Austin</a>
                  <?php if($tertiary_logo_title != false): ?>
                    <a href="<?php print $tertiary_logo_link; ?>"><?php echo $tertiary_logo_title; ?></a>
                  <?php endif; ?>
                </div>

                <?php if($site_name): ?>
                  <a href="<?php print $base_path; ?>" class="current-directory" id="show-parents"><span class="name"><?php print $site_name; ?></span><span class="toggle"></span></a>
                <?php else: ?>
                  <a href="<?php print $base_path; ?>" class="current-directory" id="show-parents"><span class="name">Home</span><span class="toggle"></span></a>
                <?php endif; ?>
              </div>

              <div class="nav-item-search show-for-large-up">
                <?php
                if ($display_persona_menu == 'persona_menu') {
                   print render($page['menus']['core_personas']);
                }
                else {
                   $block = module_invoke('block','block_view','1');
                   print render($block['content']);
                } ?>
                <div class="nav-search-container">
                  <?php print render($header_search_cse); ?>
                </div>
              </div>

              <ul class="topnav-links hide-for-large-up">
                <li class="nav-item nav-item-search">
                  <div class="nav-search-container">
                    <?php print render($header_search_cse); ?>
                  </div>
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
