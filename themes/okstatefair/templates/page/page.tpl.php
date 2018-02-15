<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
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
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>
<?php print isset($google_tag_manager) ? $google_tag_manager : ''; ?>
<?php if (isset($pixel)) : ?>
<script type="text/javascript">
  var ebRand = Math.random()+"";
  ebRand = ebRand * 1000000;
  //<![CDATA[
  document.write('<scr'+'ipt src="HTTP://bs.serving-sys.com/Serving/ActivityServer.bs?cn=as&amp;ActivityID=666087&amp;rnd=' + ebRand + '"></scr' + 'ipt>');
  //]]>
</script>
<noscript>
  <img width="1" height="1" style="border:0" src="HTTP://bs.serving-sys.com/Serving/ActivityServer.bs?cn=as&amp;ActivityID=666087&amp;ns=1"/>
</noscript>
<?php endif; ?>
<div id="page-wrapper" class="page <?php print $site_type; ?>">

  <?php print render($page['header']); ?>

  <div id="main-wrapper"><div id="main" class="clearfix">

      <div class="body">
        <div class="body-shadow"></div>
        <div class="body-inner">
          <div class="body-content">
            <?php print $messages; ?>
                            <?php print (isset($year_links) && !empty($year_links)) ? $year_links : ''; ?>
            <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
            <?php if ($page['sidebar_first']): ?>
              <aside class="sidebar-left">
                <?php print render($page['sidebar_first']); ?>
              </aside>
            <?php endif; ?>
            <?php if (isset($node) && (_okstate_special_performer($node) || (isset($chickasaw_nodes) && in_array($node->nid, $chickasaw_nodes)) || in_array($node->nid, private_events()) || $node->nid == XTREME_BULLS  || $node->nid == CHICKASAW_NID || $node->nid == CHICKASAW_NID_LIVE)) : ?>
              <div class="title-promo">
                <div class="logo-promo">
                  <?php print theme('image', array('path' => path_to_theme() . '/images/' . $promo_image)); ?>
                </div>
              </div>
            <?php elseif (isset($node) && okstatefair_check_disnep_nid($node->nid)) : ?>
              <div class="title-promo"></div>
            <?php endif; ?>
            <?php print render($title_prefix); ?>
            <?php print render($title_suffix); ?>
            <?php print render($page['help']); ?>
            <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
            <?php if (isset($back_link) && !empty($back_link)): ?>
              <div class="btn-back-wrapp">
                <?php print $back_link; ?>
              </div>
            <?php endif; ?>
            <?php print render($page['content']); ?>

            <?php print $feed_icons; ?>
          </div></div></div> <!-- /.section, /#content -->

      <?php if ($page['sidebar_second']): ?>
        <div id="sidebar-second" class="column sidebar"><div class="section">
            <?php print render($page['sidebar_second']); ?>
          </div></div> <!-- /.section, /#sidebar-second -->
      <?php endif; ?>

    </div></div> <!-- /#main, /#main-wrapper -->

  <?php print render($page['footer']); ?>

</div> <!-- /#page, /#page-wrapper -->
