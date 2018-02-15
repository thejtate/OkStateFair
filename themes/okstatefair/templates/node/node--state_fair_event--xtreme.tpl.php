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
unset($content['field_sf_event_dates']['#prefix']);
unset($content['field_sf_event_dates']['#suffix']);
?>
<?php
// We hide the comments and links now so that we can render them later.
hide($content['comments']);
hide($content['links']);
hide($content['field_sf_event_dates']);
hide($content['field_sf_event_description']);
hide($content['field_sf_event_location']);
hide($content['field_sf_event_categories']);
hide($content['field_sf_event_media'][0]['field_xtreme_subpage_left_image']);
hide($content['field_sf_event_media'][0]['field_xtreme_subpage_left_text']);
hide($content['field_sf_event_media'][0]['field_xtreme_subpage_right_image']);
hide($content['field_sf_event_media'][0]['field_xtreme_bottom_image']);
hide($content['field_sf_event_media'][0]['field_xtreme_bottom_large_image']);
hide($content['field_sf_event_media'][0]['field_xtreme_subpage_right_text']);
hide($content['field_sf_event_check_back']);
hide($content['field_sf_event_check_back_desc']);
hide($content['field_sf_event_media'][0]['field_xtreme_subpage_left_link']);
hide($content['field_sf_event_media'][0]['field_xtreme_subpage_right_link']);

$left_image_link = (isset($content['field_sf_event_media'][0]['field_xtreme_subpage_left_link']) &&
  isset($content['field_sf_event_media'][0]['field_xtreme_subpage_left_link']['#items'][0]['url'])) ?
  $content['field_sf_event_media'][0]['field_xtreme_subpage_left_link']['#items'][0]['url'] : '';
$right_image_link = (isset($content['field_sf_event_media'][0]['field_xtreme_subpage_right_link']) &&
  isset($content['field_sf_event_media'][0]['field_xtreme_subpage_right_link']['#items'][0]['url'])) ?
  $content['field_sf_event_media'][0]['field_xtreme_subpage_right_link']['#items'][0]['url'] : '';
?>

<div id="node-<?php print $node->nid; ?>" class="content-info-wrapper <?php print $classes; ?> "<?php print $attributes; ?>>

  <?php if (array_key_exists('field_golden_ticket', $content) && $content['field_golden_ticket']['#items']['0']['value'] == 1): ?>
    <?php print render($golden_ticket); ?>
  <?php endif; ?>

  <?php print render($title_prefix); ?>
  <h2>September 22 & 23</h2>
<!--  <h2>--><?php //print $content['start']; ?><!--</h2>-->
  <?php print render($title_suffix); ?>
  <div class="content-info">
    <?php //print render($content['field_sf_event_dates']);  ?>
    <div class="share-wrapper social-type-5">
      <?php if (!empty($node->field_sf_event_location)): ?>
        <?php if (!empty($node->field_sf_event_location[LANGUAGE_NONE]['0']['taxonomy_term']->field_sf_event_location_large[LANGUAGE_NONE][0]['uri'])): ?>
          <?php print l($node->field_sf_event_location[LANGUAGE_NONE]['0']['taxonomy_term']->name, file_create_url($node->field_sf_event_location[LANGUAGE_NONE]['0']['taxonomy_term']->field_sf_event_location_large[LANGUAGE_NONE][0]['uri']), array('external' => TRUE, 'attributes' => array('class' => array('field-location-map-popup')))); ?>
        <?php else: ?>
          <?php print $node->field_sf_event_location[LANGUAGE_NONE]['0']['taxonomy_term']->name; ?>
        <?php endif; ?>
      <?php endif; ?>
      <span>Share</span>
      <ul class="share-list">
        <li class="item-twitter"><?php print $twitter; ?></li>
        <li class="item-facebook"><?php print $fb; ?></li>
        <li class="item-mail"><?php print $mail; ?></li>
        <li class="item-print"><?php print $print; ?></li>
      </ul>
    </div>

    <div class="info-text">
      <?php print render($content['field_sf_event_description']); ?>
    </div>
  </div>

  <div class="images-promo">
    <div class="images"><?php print theme('image', array('path' => path_to_theme() . '/images/tmp/_tmp_ext.png')); ?></div>
  </div>
</div>
<h2 class="title-custom clear-box"><?php //print t('LIVE IN CONCERT'); ?> </h2>
<?php print render($content['links']); ?>
<?php
//print render($content);
print render($content['comments']);
?>
<div class="content-wrapper clear-box  content-custom">
  <?php print render($content); ?>
  <div class="content-col col-left width-50">
    <?php if ($left_image_link): ?>
      <?php print l(render($content['field_sf_event_media'][0]['field_xtreme_subpage_left_image']), $left_image_link, array('html' => TRUE)); ?>
    <?php else: ?>
      <?php print render($content['field_sf_event_media'][0]['field_xtreme_subpage_left_image']); ?>
    <?php endif; ?>
    <div class="content-col">
      <!-- <h3><?php //print t('Show Times'); ?></h3> -->
      <?php //print render($content['field_sf_event_dates']); ?>
      <?php print render($content['field_sf_event_media'][0]['field_xtreme_subpage_left_text']); ?>
      <div class="map-ext">
        <?php if (isset($content['field_sf_event_media'][0]['field_xtreme_bottom_large_image'][0]['#item']['uri'])): ?>
          <?php print l(render($content['field_sf_event_media'][0]['field_xtreme_bottom_image']), file_create_url($content['field_sf_event_media'][0]['field_xtreme_bottom_large_image'][0]['#item']['uri']), array('external' => TRUE, 'html' => TRUE, 'attributes' => array('class' => array('field-location-map-popup')))); ?>
          <div class="btn-print-wrapp">
            <?php print l('<i class="icon-print"></i>Print Map', '<front>', array('external' => TRUE, 'html' => TRUE, 'attributes' => array('class' => array('btn-print')))); ?>
          </div>
          <div id="printing" style="display:none;">
            <div class="landscape">
              <div id="headerhead">
                <link rel="stylesheet" media="print" href="/<?php print path_to_theme() . '/css/print-landscape.css'; ?> " />
              </div>
              <?php print render($content['field_sf_event_media'][0]['field_xtreme_bottom_large_image']); ?>
            </div>
          </div>
        <?php else: ?>
          <?php print render($content['field_sf_event_media'][0]['field_xtreme_bottom_image']); ?>
        <?php endif; ?>

      </div>
    </div>
  </div>
  <div class="content-col col-right width-50">

    <div class="description">
      <?php if ($right_image_link): ?>
        <?php print l(render($content['field_sf_event_media'][0]['field_xtreme_subpage_right_image']), $right_image_link, array('html' => TRUE)); ?>
      <?php else: ?>
        <?php print render($content['field_sf_event_media'][0]['field_xtreme_subpage_right_image']); ?>
      <?php endif; ?>
      <div class="content-col">
        <?php print render($content['field_sf_event_media'][0]['field_xtreme_subpage_right_text']); ?>
      </div>
    </div>
  </div>

</div>
<div id="printing-page" style="display:none">
  <div class="print print-concert">
    <h1><?php print $title; ?></h1>

    <?php
    if (isset($dates) && !empty($dates)) {
      foreach ($dates as $delta => $item) {
        print '<h5>' . render($item) . '</h5>';
      }
    }
    ?>
    <?php print render($content['field_sf_event_description']); ?>
    <h6><?php print t('CONCERTS ARE FREE WITH GATE ADMISSION'); ?></h6>
    <?php print render($content['field_sf_event_media'][0]['field_xtreme_subpage_left_text']); ?>
    <?php print render($content['field_sf_event_media'][0]['field_xtreme_subpage_right_text']); ?>
  </div>
</div>
<iframe name=print_frame width=0 height=0 frameborder=0 src=about:blank style="display: none;"></iframe>
<div class="change-node-date">
  <?php print t('This page updated on ') . format_date($changed, 'update_node'); ?>
</div>