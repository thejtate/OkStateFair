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
$img = '';
?>
<a href="#" class="link-print"></a>
<?php print render($content['calendar_dates']); ?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>

<table class="body-content-columns">
  <tbody><tr>
      <td class="col-1">
        <div class="content">
          <h1><?php print $title; ?></h1>

          <h2><?php print $content['start']; ?></h2>
          <?php if (array_key_exists('field_sf_event_location', $content)) : ?>
            <?php $field_sf_event_location = $content['field_sf_event_location']['#items'][0]['taxonomy_term']; ?>
            <?php if (isset($field_sf_event_location->field_location_front_name) && !empty($field_sf_event_location->field_location_front_name[LANGUAGE_NONE][0]['value'])) :
              $loc_title = $field_sf_event_location->field_location_front_name[LANGUAGE_NONE][0]['value'];
            else :
              $loc_title = $field_sf_event_location->name;
            endif; ?>
            <h3><?php print $loc_title; ?></h3>
          <?php endif; ?> 
          <div class="share-wrapper social-type-1">
            <span>Share</span>
            <ul class="share-list">
              <li class="item-twitter"><?php print $twitter; ?></li>
              <li class="item-facebook"><?php print $fb; ?></li>
              <li class="item-mail"><?php print $mail; ?></li>
            </ul>
          </div>
          <?php print render($content['field_sf_event_description']); ?>
        </div>
        <?php if (isset($field_sf_event_location) && isset($field_sf_event_location->field_sf_event_location_map) && !empty($field_sf_event_location->field_sf_event_location_map[LANGUAGE_NONE][0]['uri'])) : ?>
          <?php $img = theme('image', array('path' => $field_sf_event_location->field_sf_event_location_map[LANGUAGE_NONE][0]['uri'], 'attributes' => array('class' => array('image')))); ?>
        <?php endif; ?> 
        <div class="map-wrapper">
          <?php if (!empty($field_sf_event_location->field_sf_event_location_large)): ?>
            <?php print l($img, file_create_url($field_sf_event_location->field_sf_event_location_large[LANGUAGE_NONE][0]['uri']), array('html' => TRUE, 'external' => TRUE, 'attributes' => array('class' => array('field-location-map-popup')))); ?>
            <?php print l('<i class="icon-zoom"></i> click to expand', file_create_url($field_sf_event_location->field_sf_event_location_large[LANGUAGE_NONE][0]['uri']), array('html' => TRUE, 'external' => TRUE, 'attributes' => array('class' => array('link-zoom field-location-map-popup')))); ?>          
          <?php else: ?>
            <?php print $img; ?>
          <?php endif; ?>
        </div>

      </td>
      <td class="col-2">
        <?php print render($content['field_sf_event_dates']); ?>
      </td>
    </tr>
  </tbody></table>
<?php
hide($content['field_sf_event_location']);
hide($content['field_sf_event_categories']);
hide($content['comments']);
print render($content);
//print render($content['comments']);
?>
<div class="change-node-date">
  <?php print t('This page updated on ') . format_date($changed, 'update_node' ); ?>
</div>