<?php
/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>
<ul class="slides">
  <li class="slide item-0" data-slide-id="oklahoma-state-fair">
    <div class="page page-type-4">
      <?php print $header_red; ?>
      <?php print $state_fair_page; ?>
      <?php print $footer_red; ?>
      <?php print render($calendar_agenda); ?>
      <div class="btn-full-right-1" data-goto="home">
        <div class="inner">
          <div class="arrow"></div>
        </div>
      </div>
      <a href="#" class="btn-my-agenda"></a>
    </div>
  </li>
  <li class="slide item-1" data-slide-id="home">
    <div class="page page-type-2">
      <div class="body">
        <div class="body-inner">
          <div class="columns-home">
            <div class="col-left">
              <div class="content interactive-video-container"  data-goto="oklahoma-state-fair">
                <div id="countdown">
                  <div class="countdown-inner"></div>
                </div>
                <div class="video-container">
                  <img src="/<?php print path_to_theme() . '/images/SF Portal image.jpg'; ?>" class="poster">
                  <video preload autobuffer loop height="505" poster="/<?php print path_to_theme() . '/images/SF Portal image.jpg'; ?>">
                    <source type="video/mp4" src="<?php print path_to_theme() . '/move/Carousel.mp4'; ?>">
                    <source type="video/webm" src="<?php print path_to_theme() . '/move/Carousel.webm'; ?>">
                  </video>
                </div>
                <div class="content-inner">
                <div class="logo-inner">
                  <?php print theme('image', array('path' => path_to_theme() . '/images/log_col_2017-left.png')); ?>
                </div>
                </div>
              </div>
              <?php print render($content['field_home_left_links']); ?>
            </div>
            <div class="col-middle">
              <div class="top-buttons">
                <ul>
                  <li class="btn-search">
                    <div class="btn">SEARCH</div>

                      <?php print $search; ?>

                  </li>
                </ul>
              </div>

              <?php print l('<span class="icon-tickets">' . t('Get Your TICKETS') . '</span>', $tickets, array('attributes' => array('class' => array('btn-tickets')), 'html' => TRUE)); ?>
            </div>
            <div class="col-right">
              <div class="content interactive-video-container"  data-goto="state-fair-park">
                <div class="video-container">
                  <img src="/<?php print path_to_theme() . '/images/SFP Portal image.jpg'; ?>" class="poster">
                  <video muted preload autobuffer loop poster="/<?php print path_to_theme() . '/images/SFP Portal image.jpg'; ?>" height="505">
                    <source type="video/mp4" src="/<?php print path_to_theme() . '/move/waterfal.mp4'; ?>">
                    <source type="video/webm" src="/<?php print path_to_theme() . '/move/waterfal.webm'; ?>">
                  </video>
                </div>
<!--                <div class="overlay"></div>-->
                <div class="content-inner">
                <div class="logo-inner">
                  <?php print theme('image', array('path' => path_to_theme() . '/images/log_col-right.png')); ?>
                </div>
                </div>
              </div>
              <div class="block-buttons">
                <?php print render($content['field_home_right_links']); ?>
              </div>
            </div>
          </div>
          <div class="footer-type-1">
            <ul class="icons">
              <li>
                <?php print theme('image', array('path' => drupal_get_path('theme', 'okstatefair') . '/images/tmp/icon-dr-pepper.png')); ?> 
              </li>
<!--              <li>-->
<!--                --><?php //print theme('image', array('path' => drupal_get_path('theme', 'okstatefair') . '/images/tmp/icon-cox.png')); ?><!-- -->
<!--              </li>-->
            </ul>
          </div>
        </div>
      </div>
    </div>
  </li>
  <li class="slide item-2" data-slide-id="state-fair-park">
    <div class="page page-type-3">
      <?php print $header_blue; ?>
      <?php print $state_fair_park_page; ?>
      <?php print $footer_blue; ?>

      <div class="btn-full-right-2" data-goto="home">
        <div class="inner">
          <div class="arrow"></div>
        </div>
      </div>
    </div>
  </li>
</ul>