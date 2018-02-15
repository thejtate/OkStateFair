<?php
/**
 * @file
 * Template file for the example display.
 *
 * Variables available:
 * 
 * $plugin: The pager plugin object. This contains the view.
 *
 * $plugin->view
 *   The view object for this navigation.
 *
 * $nav_title
 *   The formatted title for this view. In the case of block
 *   views, it will be a link to the full view, otherwise it will
 *   be the formatted name of the year, month, day, or week.
 *
 * $prev_url
 * $next_url
 *   Urls for the previous and next calendar pages. The links are
 *   composed in the template to make it easier to change the text,
 *   add images, etc.
 *
 * $prev_options
 * $next_options
 *   Query strings and other options for the links that need to
 *   be used in the l() function, including rel=nofollow.
 */
?>
<?php if ( $plugin->view->name == OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_PARK_CALENDAR): ?>

  <div class="cell-calendar-header">
    <div class="month"><?php print date("F", strtotime("2013-" . $selected_month . "-1")); ?></div>
    <div class="btn-month-menu">
      <a class="spiner-calendar" href="#">
        <span class="spiner-calendar-icon">open</span>
      </a>
      <div class="month-menu">
        <ul class="pager">
          <?php for ($number = 1; $number <= 12; ++$number): ?>
            <?php if( (int)$selected_month == (int)$number): ?>
              <?php $attr = array('class' => array('selected')); ?>
            <?php else: ?>
              <?php $attr = array(); ?>
            <?php endif; ?>
            <li><?php print l( date("F", strtotime("2013-" . $number . "-1")) , OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_PARK_CALENDAR_PAGE_PATH . '/' . $selected_year . '-' . $number , array('absolute' => TRUE, 'attributes' => $attr, 'query' => $select_query)); ?></li>
          <?php endfor; ?>
        </ul>
      </div>
    </div>
  </div>

<?php else: ?>
  <?php if (!empty($pager_prefix)) print $pager_prefix; ?>
  <div class="date-nav-wrapper clearfix<?php if (!empty($extra_classes)) print $extra_classes; ?>">
    <div class="date-nav item-list">
      <div class="date-heading">
        <h3><?php print $nav_title ?></h3>
      </div>
      <ul class="pager">
      <?php if (!empty($prev_url)) : ?>
        <li class="date-prev">
          <?php print l('&laquo;' . ($mini ? '' : ' ' . t('Prev', array(), array('context' => 'date_nav'))), $prev_url, $prev_options); ?>
        &nbsp;</li>
      <?php endif; ?>
      <?php if (!empty($next_url)) : ?>
        <li class="date-next">&nbsp;
          <?php print l(($mini ? '' : t('Next', array(), array('context' => 'date_nav')) . ' ') . '&raquo;', $next_url, $next_options); ?>
        </li>
      <?php endif; ?>
      </ul>
    </div>
  </div>
<?php endif; ?>
