<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
?>
  <div class="quick-links" id="quick-links">
    <div class="ql-toggle">Quick Links</div>
    <div class="ql-container">
      <?php print render($page['quick_links']); ?>
    </div>
  </div>
  <header class="header" id="header" role="banner">

    <?php if ($logo): ?>
    <div id="site-logo">
      <a href="<?php print theme_get_setting('logo_link'); ?>" title="<?php print theme_get_setting('logo_alt_text'); ?>" rel="home"><img src="<?php print $logo; ?>" alt="<?php print theme_get_setting('logo_alt_text'); ?>" class="site-logo-image" /></a>
    </div>
    <?php endif; ?>

    <?php print render($page['header']); ?>

  </header>

  <?php if ($site_name): ?>
      <div class="name-and-slogan" id="name-and-slogan">
        <?php if ($site_name): ?>
          <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" class="site-link" rel="home">
            <h1 class="site-name" id="site-name"><?php print $site_name; ?></h1>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  <div id="navigation">

      <div class="menu-toggle">Menu</div>
      <?php print render($page['navigation']); ?>

    </div>

<div id="page">
  <?php print render($page['highlighted']); ?>
  <div id="main">
    <div id="content" class="column" role="main">
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <h1 class="page__title title" id="page-title"><?php print $title; ?></h1>
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

    <?php
      // Render the sidebars to see if there's anything in them.
      $sidebar_first  = render($page['sidebar_first']);
      $sidebar_second = render($page['sidebar_second']);
    ?>

    <?php if ($sidebar_first || $sidebar_second): ?>
      <aside class="sidebars">
        <?php print $sidebar_first; ?>
        <?php print $sidebar_second; ?>
      </aside>
    <?php endif; ?>

  </div>

</div>

<div class="footer-bar"></div>
<?php print render($page['footer']); ?>

<?php print render($page['bottom']); ?>
