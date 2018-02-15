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
$out = '';
$tags = '';
?>
<div id="node-<?php print $node->nid; ?>" class="content-inner <?php print $classes; ?> clearfix"<?php print $attributes; ?>>


  <?php print render($title_prefix); ?>

  <?php if ($teaser): ?>
    <h1> <?php print l($title, 'node/' . $nid, array('html' => TRUE)); ?></h1>
  <?php else: ?>
    <h1><?php print $title ?></h1>
  <?php endif; ?>

  <?php print render($title_suffix); ?>
  <article class="content">
    <div class="info">
      <?php print render($content['field_blog_date']); ?> | <?php print render($content['field_blog_author']); ?>
    </div>
    <?php print render($content['body']); ?>
    <div class="media_response">
      <div class="share-wrapper social-type-4">
        <span>Share on</span>
        <ul class="share-list">
          <li class="item-twitter"><?php print $twitter; ?></li>
          <li class="item-facebook"><?php print $fb; ?></li>
          <li class="item-print"><?php print $print; ?></li>
        </ul>
      </div>
      <?php
      if (isset($comment_count)) :
        print l($comment_count . ($comment_count != 1 ? ' Comments' : ' Comment'), '#', array('attributes' => array('class' => array('link-comments'))));
      endif;
      ?>
    </div>
    <?php
    // We hide the comments and links now so that we can render them later.
    hide($content['comments']);
    hide($content['field_blog_categories']);
    hide($content['field_blog_tags']);
    hide($content['links']);
    print render($content);
//    if (isset($field_blog_categories) && !empty($field_blog_categories)) {
//      $len = count($field_blog_categories);
//      $comma = ', ';
//      foreach ($field_blog_categories as $key => $value) {
//        if ($key == $len - 1)
//          $comma = '';
//        $out .= '<span class="category">' . l($value['taxonomy_term']->name, 'blog/all/'. $value['taxonomy_term']->tid) . '</span>' . $comma;
//      }
//    }
    if (isset($field_blog_tags) && !empty($field_blog_tags)) {
      $len = count($field_blog_tags);
      $comma = ', ';
      foreach ($field_blog_tags as $key => $value) {
        if ($key == $len - 1)
          $comma = '';
        $tags .= '<span class="category">' . l($value['taxonomy_term']->name, 'blog/all/all/'. $value['taxonomy_term']->tid) . '</span>' . $comma;
      }
    }
    ?>

    <?php //print render($content['links']);  ?>
    <div class="posted-tags">
<!--      <span class="posted"><?php //print t('Posted in ') . $out; ?></span>-->
      <span class="tags"><?php print t('Tags: ') . $tags; ?></span>
    </div>
  </article>
  <?php print render($content['comments']); ?>
  <?php if ($view_mode != 'teaser') : ?>
    <div class="change-node-date">
      <?php print t('This page updated on ') . format_date($changed, 'update_node'); ?>
    </div>
  <?php endif; ?>
  </div>