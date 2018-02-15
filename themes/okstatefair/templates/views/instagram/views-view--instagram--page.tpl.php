<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
?>
<div class="share-wrapper social-type-3">
  <span><?php print t('Share'); ?></span>
  <ul class="share-list">
    <?php
    $url_for_share = urlencode(url('instagram', array('absolute' => TRUE)));
    $share_title = t('Instagram fair fun photo feed');
    $twitter = l('twitter', 'http://twitter.com/share?url=' . $url_for_share . '&text=' . $share_title, array('external' => TRUE));
    $fb = l('facebook', 'https://www.facebook.com/sharer.php?u=' . $url_for_share . '&t=' . $share_title, array('external' => TRUE));
    $mail = l('mail', 'mailto:?subject=' . $share_title . '&body='. $url_for_share, array('external' => TRUE));
    ?>
    <li class="item-twitter"><?php print $twitter; ?></li>
    <li class="item-facebook"><?php print $fb; ?></li>
    <li class="item-mail"><?php print $mail; ?></li>
  </ul>
</div>
<div class="content-info-wrapper">
  <?php print theme('image', array('path' => path_to_theme() . '/images/tmp/title-instagram.png')); ?>
<!--  <h1>--><?php //print t('Instagram'); ?><!--</h1>-->
<!---->
<!--  <p><span>--><?php //print t('FAIR FUN'); ?><!--</span><span>--><?php //print t('PHOTO FEED'); ?><!--</span></p>-->
</div>
<div class="info-text">
  <span><?php print t('Join in!'); ?></span> <?php print t('Use the hashtag'); ?>
  <strong>#<?php print t('okstatefair'); ?></strong> <?php print t('or'); ?>
  <strong>#<?php print t('AGreatDealofFun'); ?></strong>
  <?php print t('and we will feature your image you on our '); ?><a href="<?php print url(variable_get('instagram', 'https://www.instagram.com/okstatefair/'))?>" target="_blank"> <strong><?php print t('Instagram!'); ?></strong></a>
</div>
<div class="<?php print $classes; ?>">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php if ($rows): ?>
    <div class="view-content block-photos">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty block-photos">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>
  <div class="pager-wrapper-2">
    <div class="item-list">
      <?php if ($pager): ?>
        <?php print $pager; ?>
      <?php endif; ?>
    </div>
  </div>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div><?php /* class view */ ?>
