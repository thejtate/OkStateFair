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
  <h1><?php print t('Instagram'); ?></h1>

  <p><span><?php print t('FAIR FUN'); ?></span><span><?php print t('PHOTO FEED'); ?></span></p>
</div>
<div class="info-text">
  <span><?php print t('Join in!'); ?></span> <?php print t('Use the hashtag'); ?> <strong>#<?php print t('mileofsmilesOK'); ?></strong>
  <?php print t('and we will feature your image on this page.'); ?>
</div>
<div class="block-photos">
  <div class="instagram"></div>
  <div class="clearfix"></div>
  <div class="instagram-button-wraper">
    <div class="btn-back-wrapp">
      <a class="btn-back instagram-more" href="#">More</a>
    </div>
  </div
  <div class="clearfix"></div>
</div>