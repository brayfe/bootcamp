<?php
/**
 * @file
 * Partial file to display the footer.
 *
 * @todo ITS to update this file when Subscribe to our Newsletter module has
 *   been completed.
 */
?>
    <div class="container container-footer footer-theme2">
      <div class="row">

        <div class="column small-12 medium-4">
          <div class="footer-primary">
            <div class="footer-logo">
              <a href="<?php print $base_path; ?>" class="main-logo"><span class="hiddenText"><?php print $site_name; ?></span></a>
            </div>
              <div class="footer-contact">
                <p>                 
                  <?php print render($footer_text); ?>
                </p>
                
              </div>

              <div class="connect">
                <?php if ($display_social == '1'): ?>
                <?php $block = module_invoke('block','block_view','1');
                    print render($block['content']); ?>
                <?php endif; ?>
              </div>
            </div>
        </div>

        <div class="column small-12 medium-4">
          <div class="footer-secondary">
              <?php print render($page['menus']['core_helpful_links']); ?>
           </div>
        </div>

        <div class="column small-12 medium-4">
          <div class="footer-tertiary">
            <?php if(($newsletter_exists == 1) && ($newsletter_url)): ?>            
              <div class="newsletter">
                 <a href="<?php print render($newsletter_url); ?>" target="_blank" class="cta sidebar-cta"><span>Subscribe to our newsletter</span></a>
              </div>
            <?php endif; ?>
            <ul class="helpful-links small-block-grid-2">
              <li class="helpful-link-item"><a href="http://www.utexas.edu" class="helpful-link">UT Austin Home</a></li>
              <li class="helpful-link-item"><a href="http://www.utexas.edu/emergency" class="helpful-link">Emergency Information</a></li>
              <li class="helpful-link-item"><a href="http://www.utexas.edu/site-policies" class="helpful-link">Site Policies</a></li>
              <li class="helpful-link-item"><a href="http://www.utexas.edu/cio/policies/web-accessibility" class="helpful-link">Web Accessibility Policy</a></li>
              <li class="helpful-link-item"><a href="http://www.utexas.edu/cio/policies/web-privacy" class="helpful-link">Web Privacy Policy</a></li>
              <li class="helpful-link-item"><a href="https://get.adobe.com/reader/" class="helpful-link">Adobe Reader</a></li>
            </ul>
          </div>
        </div>

      </div>

        <div class="row">
          <br/>
          <br/>
          <div class="copyright">&copy; The University of Texas at Austin <?php echo date("Y"); ?></div>
        </div>
    </div><!--container-footer-->
