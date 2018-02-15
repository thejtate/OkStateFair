<div class="my-agenda">
  <div class="content-agenda-wrapper">

    <a href="#" class="btn-my-agenda">
      <span class="hover-agenda"></span>
      <span class="icon-agenta"><?php print t('agenda'); ?></span>
    </a>
    <div class="content-agenta">
    </div>
    <div class="ajax-loader"></div>
    <div class="empty-agenda">
      <div class="empty-img"></div>
      <div class="empty-text">
        <?php print t('To add events to your Agenda, simply click “Add to Agenda” next to an event and it will populate in this window.');?>
      </div>
    </div>
    <div class="btn-group">
      <a class="btn btn-left" href="#"><?php print t('SHARE'); ?></a>
      <div class="wrapper-share-wrapper">
        <ul class="list-share">
          <li class="item-twitter">
            <a href="#" data-opener="allow-propagation"><i class="icon" data-opener="allow-propagation"></i></a>
          </li>
          <li class="item-facebook"><a href="#" data-opener="allow-propagation"><i class="icon" data-opener="allow-propagation"></i></a></li>
          <li class="item-mail"><a href="#" data-opener="allow-propagation"><i class="icon" data-opener="allow-propagation" ></i></a></li>
        </ul>
      </div>
      <div class="share-ajax-loader"></div>
      <a class="btn btn-right" href="#"><?php print t('PRINT'); ?></a>
    </div>
  </div>
</div>
<iframe name=print_frame width=0 height=0 frameborder=0 src=about:blank style="display: none;"></iframe>



