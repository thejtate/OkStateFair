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
unset($content['field_sfp_event_dates']['#prefix']);
unset($content['field_sfp_event_dates']['#suffix']);
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>
<table class="body-content-columns-3">
  <tbody>
  <tr>
    <td class="col-1">
        <?php print $calendar;?>
    </td>
    <td class="col-2">

      <h1><?php print $title; ?></h1>
      <!--        <h2>--><?php //print $date_interval; ?><!--</h2>-->

        <?php if (!empty($node->field_sfp_event_locations[LANGUAGE_NONE])): ?>
          <p class="style-3">
              <?php foreach($node->field_sfp_event_locations[LANGUAGE_NONE] as $key => $val):  ?>
                <?php if( !empty($val['taxonomy_term']->field_location_map_small[LANGUAGE_NONE][0]['uri'])): ?>
                <?php print ($key == 0 ? '' : ' • ');?>
                  <?php print l( $val['taxonomy_term']->name, file_create_url($val['taxonomy_term']->field_location_map_small[LANGUAGE_NONE][0]['uri']), array('external' => TRUE, 'attributes' => array('class' => array('field-location-map-popup')))); ?>
                <?php else: ?>
                  <?php print $val['taxonomy_term']->name; ?>
                <?php endif; ?>
              <?php endforeach; ?>
            </p>
        <?php endif; ?>


      <?php print render($content['field_sfp_event_description']); ?>
      <?php if (isset($content['field_sfp_event_url']) && !empty($content['field_sfp_event_url'])) : ?>
        <div class="link">
          <p>
            <?php print render($content['field_sfp_event_url']); ?>
          </p>
        </div>
      <?php endif; ?>
      <?php print render($content['field_sfp_event_dates']); ?>

      <?php if(!empty($content['field_sfp_event_tickets_online']) || !empty($content['field_sfp_event_tickets_at_door']['#items'][0]['value']) || !empty($content['field_sfp_event_admission_fees'])): ?>
        <div class="admission-fees-list">
          <h4>Admission</h4>
        </div>
      <?php endif; ?>


      <div class="link">
        <?php $tickets_at_door = $content['field_sfp_event_tickets_at_door']['#items'][0]['value'] ? 'Purchase Tickets at the Door' : ''; ?>
        <span class="style-1 static"><?php print $tickets_at_door; ?></span>

        <!--      --><?php //print render($content['field_sfp_event_url']); ?>

          <div>
          <?php print render($content['field_sfp_event_tickets_online']); ?>
          </div>
      </div>
      </div>

      <?php print render($content['field_sfp_event_admission_fees']); ?>
      <br/>
      <div class="share-wrapper social-type-2">
        <span><?php print t('Share'); ?></span>
        <ul class="share-list">
          <li class="item-twitter"><?php print $twitter; ?></li>
          <li class="item-facebook"><?php print $fb; ?></li>
          <li class="item-mail"><?php print $mail; ?></li>
          <li class="item-print"><?php print $print; ?></li>
        </ul>
      </div>

    </td>
  </tr>
  </tbody>
</table>
<?php hide($content['field_sfp_event_tickets_at_door']); ?>
<?php print render($content['comments']); ?>

<div class="footer-text">
  <?php if (!empty($updated_date)): ?>
    <div class="update-info">Page updated on <?php print format_date($node->changed, 'updated_date'); ?></div>
  <?php endif; ?>
  <?php if (!empty($event_park_warning)): ?>
    <?php print $event_park_warning; ?>
  <?php endif; ?>
</div>
<div class="change-node-date">
  <?php print t('This page updated on ') . format_date($changed, 'update_node'); ?>
</div>