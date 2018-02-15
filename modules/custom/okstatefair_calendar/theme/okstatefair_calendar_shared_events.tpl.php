<?php if (!empty($empty_message)): ?>
  <h1><?php print($empty_message); ?></h1>
<?php else: ?>
  <h1><?php print t('Events'); ?></h1>
  <div class="table-event-wrapp shared-events table-schedule">
    <?php print $table; ?>
  </div>

  <div class="pager-wrapper">
    <div class="item-list">
      <?php print $pager; ?>
    </div>
  </div>
<?php endif; ?>