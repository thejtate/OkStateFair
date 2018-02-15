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
hide($content['field_sf_event_description']);
hide($content['field_sf_event_location']);
hide($content['field_sf_event_categories']);
hide($content['field_sf_event_check_back']);
hide($content['field_sf_event_check_back_desc']);
?>
<?php
$add_cl .= '';
if (isset($content['field_sf_event_media'])) :
  if (isset($content['field_sf_event_media'][0]['field_event_image']))
    $horiz = TRUE;
  else {
    $horiz = FALSE;
    $add_cl .= ' full-block';
  }
else :
  $horiz = FALSE;
endif;

$page_combined = !empty($combined) ? $combined : FALSE;
$first_section = !empty($first_section) ? $first_section : FALSE;
$combined_title = !empty($combined_title) ? $combined_title : '';
?>

<div id="node-<?php print $node->nid; ?>" class="content-info-wrapper <?php print $classes . $add_cl; ?> "<?php print $attributes; ?>>

  <?php if(!$page_combined): ?>
    <?php print render($title_prefix); ?>
    <h2><?php print htmlspecialchars_decode(render($content['field_event_title'])); ?></h2>
    <?php print render($title_suffix); ?>
  <?php elseif (!empty($combined_title)): ?>
    <h2><?php print $combined_title; ?></h2>
  <?php endif; ?>

  <div class="content-info">
    <div class="clearfix">
    <?php print render($content['field_sf_event_dates']); ?>
    <?php if ($horiz) : ?>

      <?php if (!$page_combined || ($page_combined && $first_section)) : ?>
        <div class="share-wrapper social-type-1">
          <?php if (!empty($node->field_sf_event_location[LANGUAGE_NONE])): ?>
            <?php foreach ($node->field_sf_event_location[LANGUAGE_NONE] as $key => $val): ?>
              <?php if (isset($val['taxonomy_term']->field_location_front_name) && !empty($val['taxonomy_term']->field_location_front_name[LANGUAGE_NONE][0]['value'])) :
                $loc_title = $val['taxonomy_term']->field_location_front_name[LANGUAGE_NONE][0]['value'];
              else :
                $loc_title = $val['taxonomy_term']->name;
              endif; ?>
              <?php if (!empty($val['taxonomy_term']->field_sf_event_location_large[LANGUAGE_NONE][0]['uri'])): ?>
                <?php print l($loc_title, file_create_url($val['taxonomy_term']->field_sf_event_location_large[LANGUAGE_NONE][0]['uri']), array('external' => TRUE, 'attributes' => array('class' => array('field-location-map-popup')))); ?>
              <?php else: ?>
                <?php print l($loc_title, 'javascript:void();', array('external' => TRUE, 'attributes' => array('class' => array('')))); ?>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
          <span>Share</span>
          <ul class="share-list">
            <li class="item-twitter"><?php print $twitter; ?></li>
            <li class="item-facebook"><?php print $fb; ?></li>
            <li class="item-mail"><?php print $mail; ?></li>
            <li class="item-print"><?php print $print; ?></li>
          </ul>
        </div>
      <?php endif; ?>
      </div>

      <?php if($page_combined): ?>
        <?php print render($title_prefix); ?>
        <h2><?php print htmlspecialchars_decode(render($content['field_event_title'])); ?>    </h2>
        <?php print render($title_suffix); ?>
      <?php endif; ?>

      <div class="info-text">
        <?php print render($content['field_sf_event_description']); ?>
      </div>
    <?php else: ?>
      <?php if (!$page_combined || ($page_combined && $first_section)) : ?>
        <div class="share-wrapper social-type-1">
          <?php if (!empty($node->field_sf_event_location[LANGUAGE_NONE])): ?>
            <?php foreach ($node->field_sf_event_location[LANGUAGE_NONE] as $key => $val): ?>
              <?php if (!empty($val['taxonomy_term']->field_sf_event_location_large[LANGUAGE_NONE][0]['uri'])): ?>
                <?php print l($val['taxonomy_term']->name, file_create_url($val['taxonomy_term']->field_sf_event_location_large[LANGUAGE_NONE][0]['uri']), array('external' => TRUE, 'attributes' => array('class' => array('field-location-map-popup')))); ?>
              <?php else: ?>
                <?php print l($val['taxonomy_term']->name, 'javascript:void();', array('external' => TRUE, 'attributes' => array('class' => array('')))); ?>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
          <span>Share</span>
          <ul class="share-list">
            <li class="item-twitter"><?php print $twitter; ?></li>
            <li class="item-facebook"><?php print $fb; ?></li>
            <li class="item-mail"><?php print $mail; ?></li>
            <li class="item-print"><?php print $print; ?></li>
          </ul>
        </div>
      <?php endif; ?>
      </div>
      <?php if (isset($content['field_sf_event_media'])) { ?>
        <?php if (array_key_exists('field_event_image_horiz', $content['field_sf_event_media'][0])) { ?>
          <div class="images-promo">
            <div class="images"><?php print render($content['field_sf_event_media'][0]['field_event_image_horiz']); ?></div>
          </div>
        <?php } ?>
      <?php } ?>

      <?php if($page_combined): ?>
        <?php print render($title_prefix); ?>
        <h2><?php print htmlspecialchars_decode(render($content['field_event_title'])); ?>    </h2>
        <?php print render($title_suffix); ?>
      <?php endif; ?>

      <div class="info-text">
        <?php print render($content['field_sf_event_description']); ?>
      </div>
      <?php if (isset($content['field_sf_event_media'])) { ?>
        <?php if (array_key_exists('field_website_link', $content['field_sf_event_media'][0])) { ?>
          <?php print render($content['field_sf_event_media'][0]['field_website_link']); ?>
        <?php } ?>
      <?php } ?>
    <?php endif; ?>
  </div>
  <?php if ($horiz) : ?>
    <?php if (isset($content['field_sf_event_media'])) { ?>
      <div class="images-promo">
        <?php if (array_key_exists('field_event_image', $content['field_sf_event_media'][0])) { ?>
          <div class="images">
            <?php print render($content['field_sf_event_media'][0]['field_event_image']); ?>
          </div>
        <?php } ?>
        <?php if (array_key_exists('field_website_link', $content['field_sf_event_media'][0])) { ?>
          <?php print render($content['field_sf_event_media'][0]['field_website_link']); ?>
        <?php } ?>
      </div>
    <?php } ?>
  <?php endif; ?>
  <?php print render($content['links']); ?>
</div>
<?php
print render($content);
print render($content['comments']);
?>
<div id="printing-page" style="display:none">
  <div class="print print-concert">
    <h1><?php print t('CHICKASAW'); ?></h1>
    <h2><?php print t('ENTERTAINMENT STAGE'); ?></h2>
    <h3><?php print $title; ?></h3>
    <?php
    if (isset($dates) && !empty($dates)) {
      foreach ($dates as $delta => $item) {
        print '<h5>' . render($item) . '</h5>';
      }
    }
    ?>
    <?php print render($content['field_sf_event_description']); ?>
    <h6><?php print t('CONCERTS ARE FREE WITH GATE ADMISSION'); ?></h6>
  </div>
</div>
<iframe name=print_frame width=0 height=0 frameborder=0 src=about:blank style="display: none;"></iframe>

<?php if (!$page_combined): ?>
<div class="change-node-date">
  <?php print t('This page updated on ') . format_date($changed, 'update_node'); ?>
</div>
<?php endif; ?>
