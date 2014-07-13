<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 * least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 * or themes/garland.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 * when linking to the front page. This includes the language domain or
 * prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 * in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 * in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 * site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 * the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 * modules, intended to be displayed in front of the main title tag that
 * appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 * modules, intended to be displayed after the main title tag that appears in
 * the template.
 * - $messages: HTML for status and error messages. Should be displayed
 * prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 * (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 * menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 * associated with the page, and the node ID is the second argument
 * in the page's path (e.g. node/12345 and node/12345/revisions, but not
 * comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 */
?>

<div class="l-page-wrapper">

<!-- top links-->
<?php if ($page['top_links']): ?>
  <div id="top-bar" class="">
    <div class="l-top-wrapper" style="max-width:<?php print $setwidth; ?>">
      <div class="top-links s-grid">
        <?php print render($page['top_links']); ?>
      </div>
    </div>
  </div>
<?php endif; ?>
<!-- //top links-->

<!-- header -->
<div id="header-bar" class="" role="banner">
  <header class="l-header" style="max-width:<?php print $setwidth; ?>">

    <!-- top left -->

    <div class="l-logo s-grid">
          <?php if ($logo): ?>
            <a href="<?php print $front_page; ?>" title="<?php print $site_name; ?> » <?php print $site_slogan; ?>">
              <img id="logo-img" src="<?php print $logo; ?>" alt="<?php print $site_name; ?> » <?php print $site_slogan; ?>"/></a>
          <?php else : ?>
            <h1 class="site-name">
              <a href="<?php print $front_page; ?>">
                <?php print $site_name; ?></a>
            </h1>
          <?php endif; ?>
    </div>
    <!--// l-logo-->

    <!-- top right -->

    <div class="l-branding s-grid">
      <?php if ($site_slogan || $site_name) : ?>
          <?php if ($logo): ?>
            <?php if ($site_name) : ?>
              <h1 class="site-name">
                <a href="<?php print $front_page; ?>">
                  <?php print $site_name; ?></a>
              </h1>
            <?php endif; ?>
          <?php endif; ?>

          <?php if ($site_slogan) : ?>
            <h3 class="brand"><?php print $site_slogan; ?></h3>
          <?php endif; ?>

      <?php endif; ?>
    </div>
    <!--//brandinl-->

  </header>

</div> <!-- // l-header -->

<div id="l-menu-wrapper"  role="navigation">
  <div class="l-menu-wrapper" style="max-width:<?php print $setwidth; ?>">
      <div id="main-menu" class="nav s-grid">

        <?php if ($main_menu): ?>
        <a id="off-canvas-left-show" href="#off-canvas" class="l-off-canvas-show l-off-canvas-show--left"><?php print t('Show Navigation'); ?></a>
        <div id="off-canvas-left" class="l-off-canvas l-off-canvas--left">
          <a id="off-canvas-left-hide" href="#" class="l-off-canvas-hide l-off-canvas-hide--left"><?php print t('Hide Navigation'); ?></a>
              <?php print render($primary_nav); ?>
        </div><!-- // off-canvas-left -->
        <?php endif; ?>
        <!-- //main menu -->

        <!-- for third party menu systems or modules-->
        <?php if ($page['thirdparty_menu']): ?>
          <?php print render($page['thirdparty_menu']); ?>
        <?php endif; ?>

      </div>
  </div>
</div>

<?php if ($breadcrumb): ?>
  <div id="breadcrumbs-wrapper" class="l-breadcrumbs">
    <div class="breadcrumbs" style="max-width:<?php print $setwidth; ?>">
      <div class="s-grid"><?php print $breadcrumb; ?></div>
    </div>
  </div>
<?php endif; ?>

<!-- preface -->
<?php if ($page['preface_first'] || $page['preface_second'] || $page['preface_third']): ?>

  <div id="preface-wrap" class="">
    <div class="l-preface" style="max-width:<?php print $setwidth; ?>">

      <!--Preface -->
      <?php if (!empty($page['preface_first'])): ?>
        <div class="preface s-grid">
          <?php print render($page['preface_first']); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($page['preface_second'])): ?>
        <div class="preface s-grid">
          <?php print render($page['preface_second']); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($page['preface_third'])): ?>
        <div class="preface s-grid">
          <?php print render($page['preface_third']); ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
  <!-- // preface -->

<?php endif; ?>

  <div class="main">
    <div class="l-main" role="main" style="max-width:<?php print $setwidth; ?>">
      <div class="l-content">
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <h1><?php print $title; ?></h1>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print $messages; ?>
      <?php print render($tabs); ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($page['content']); ?>
      <?php print $feed_icons; ?>
    </div>
      <?php print render($page['sidebar_first']); ?>
      <?php print render($page['sidebar_second']); ?>
</div>

  </div>

<?php
// Define and divide the postscript page regions.
if ($page['postscript_first'] || $page['postscript_second'] || $page['postscript_third']): ?>

  <div id="postscript-wrapper">
    <div class="grid-container" id="postscript-container" style="max-width:<?php print $setwidth; ?>">

      <!--Postscript -->
      <?php if (!empty($page['postscript_first'])): ?>

          <?php print render($page['postscript_first']); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($page['postscript_second'])): ?>

          <?php print render($page['postscript_second']); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($page['postscript_third'])): ?>

          <?php print render($page['postscript_third']); ?>
        </div>
      <?php endif; ?>

    </div>
  </div>

<?php endif; ?>


<footer id="footer" role="footer">
  <section class="grid-container" style="max-width:<?php print $setwidth; ?>">
    <div class="grid-100">
      <?php if (!empty($page['footer_first'])): ?>
        <?php print render($page['footer_first']); ?>
      <?php endif; ?>
    </div>
  </section>
</footer>

</div>

<?php if ($page['top_panel']): ?>
  <div id="top-panel">
    <?php print render($page['top_panel']); ?>
  </div>
<?php endif; ?>