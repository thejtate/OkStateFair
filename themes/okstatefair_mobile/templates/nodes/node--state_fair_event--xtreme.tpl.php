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
$left_image_link = (isset($content['field_sf_event_media'][0]['field_xtreme_subpage_left_link']) &&
  isset($content['field_sf_event_media'][0]['field_xtreme_subpage_left_link']['#items'][0]['url'])) ?
  $content['field_sf_event_media'][0]['field_xtreme_subpage_left_link']['#items'][0]['url'] : '';
$right_image_link = (isset($content['field_sf_event_media'][0]['field_xtreme_subpage_right_link']) &&
  isset($content['field_sf_event_media'][0]['field_xtreme_subpage_right_link']['#items'][0]['url'])) ?
  $content['field_sf_event_media'][0]['field_xtreme_subpage_right_link']['#items'][0]['url'] : '';
?>
<div class="content-wrapper">
  <div class="content-text">
    <div class="btn-back">
      <?php print l(t('FULL SCHEDULE'), 'mobile-state-fair-calendar', array('attributes' => array('class' => array('btn')))); ?>
    </div>
    <div class="logo">
      <?php print theme('image', array('path' => path_to_theme() . '/images/logo_promo_custom-2.png')); ?>
    </div>
    <div class="content-item item-odd">
      <?php print render($title_prefix); ?>
      <!--      <h1>--><?php //print $title; ?><!--</h1>-->
      <h3><?php print $content['start']; ?></h3>
      <?php print render($title_suffix); ?>

      <div class="share-wrapper social-type">
        <?php if (!empty($node->field_sf_event_location[LANGUAGE_NONE])): ?>
          <?php foreach ($node->field_sf_event_location[LANGUAGE_NONE] as $key => $val): ?>
            <?php if (isset($val['taxonomy_term']->field_location_front_name) && !empty($val['taxonomy_term']->field_location_front_name[LANGUAGE_NONE][0]['value'])) :
              $loc_title = $val['taxonomy_term']->field_location_front_name[LANGUAGE_NONE][0]['value'];
            else :
              $loc_title = $val['taxonomy_term']->name;
            endif; ?>
            <?php if (!empty($val['taxonomy_term']->field_sf_event_location_map[LANGUAGE_NONE][0]['uri'])): ?>
              <?php print l($loc_title, file_create_url($val['taxonomy_term']->field_sf_event_location_map[LANGUAGE_NONE][0]['uri']), array(
                'external' => TRUE,
                'attributes' => array('class' => array('link-where'))
              )); ?>
            <?php else: ?>
              <span class="link-where"><?php print $loc_title; ?></span>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>

        <span class="share-title"><?php print t('Share'); ?></span>
        <ul class="share-list type-share-1">
          <li class="item-twitter"><?php print $twitter; ?></li>
          <li class="item-facebook"><?php print $fb; ?></li>
          <li class="item-mail"><?php print $mail; ?></li>
        </ul>
      </div>
      <div class="table-schedule">
        <!--        --><?php //print render($content['field_sf_event_dates']); ?>
      </div>
      <?php print render($content['field_sf_event_description']); ?>
      <div>
        <div class="logo">
        <?php if ($left_image_link): ?>
          <?php print l(render($content['field_sf_event_media'][0]['field_xtreme_subpage_left_image']), $left_image_link, array('html' => TRUE)); ?>
        <?php else: ?>
          <?php print render($content['field_sf_event_media'][0]['field_xtreme_subpage_left_image']); ?>
        <?php endif; ?>
      </div>
    </div>
    <div>
      <div class="description">
        <div class="logo">
          <?php if ($right_image_link): ?>
            <?php print l(render($content['field_sf_event_media'][0]['field_xtreme_subpage_right_image']), $right_image_link, array('html' => TRUE)); ?>
          <?php else: ?>
            <?php print render($content['field_sf_event_media'][0]['field_xtreme_subpage_right_image']); ?>
          <?php endif; ?>
        </div>
      </div>
    </div>


    <div class="content-item item-odd">
      <div class="content-col">
        <!-- <h3><?php //print t('Show Times'); ?></h3> -->
        <?php //print render($content['field_sf_event_dates']); ?>
        <?php print render($content['field_sf_event_media'][0]['field_xtreme_subpage_left_text']); ?>
        <div class="map-ext">
          <?php if (isset($content['field_sf_event_media'][0]['field_xtreme_bottom_large_image'][0]['#item']['uri'])): ?>
            <?php print l(render($content['field_sf_event_media'][0]['field_xtreme_bottom_image']), file_create_url($content['field_sf_event_media'][0]['field_xtreme_bottom_large_image'][0]['#item']['uri']), array(
              'external' => TRUE,
              'html' => TRUE,
              'attributes' => array('class' => array('field-location-map-popup'))
            )); ?>
            <div id="printing" style="display:none;">
              <div class="landscape">
                <div id="headerhead">
                  <link rel="stylesheet" media="print"
                        href="/<?php print path_to_theme() . '/css/print-landscape.css'; ?> "/>
                </div>
                <?php print render($content['field_sf_event_media'][0]['field_xtreme_bottom_large_image']); ?>
              </div>
            </div>
          <?php else: ?>
            <?php print render($content['field_sf_event_media'][0]['field_xtreme_bottom_image']); ?>
          <?php endif; ?>

        </div>
      </div>
      <div class="content-col">
        <?php print render($content['field_sf_event_media'][0]['field_xtreme_subpage_right_text']); ?>
      </div>
    </div>
  </div>
</div>