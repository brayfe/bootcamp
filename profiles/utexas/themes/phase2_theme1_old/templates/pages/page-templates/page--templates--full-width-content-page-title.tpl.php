<?php
/**
 * @file
 * Template for Full Width Content Pages with a title.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 * - $partials_dir: The directory where partials are found.
 * - $locked_fields: Any fields locked to this page template.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable.
 */
?>
<?php require_once($partials_dir . 'header.inc'); ?>

<div class="UT-page" id="ut-page-content" role="main">
  <?php require_once($partials_dir . 'timely-announcement.inc'); ?>
  <div class="container container-top search">
    <?php require_once($partials_dir . 'breadcrumbs.inc'); ?>
    <?php require_once($partials_dir . 'page-top.inc'); ?>

    <div class="row">
      <div class="column medium-centered medium-10 large-9">
        <h1 class="page-title <?php echo $hide_homepage_title; ?>"><?php print $title; ?></h1>
      </div>
    </div>

    <?php if (isset($page['content_top'])): ?>
      <div class="row">
        <div class="column medium-centered medium-10 large-9">
          <?php print render($page['content_top']); ?>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <div class="container container-bottom bottom-search">
    <?php if (isset($page['content_bottom'])): ?>
      <section class="main-content">
        <div class="row">
          <div class="column medium-centered medium-10 large-9">
            <?php print render($page['content_bottom']); ?>
          </div>
        </div>
      </section>
    <?php endif; ?>
  </div>

  <?php require_once($partials_dir . 'footer.inc'); ?>
</div>
