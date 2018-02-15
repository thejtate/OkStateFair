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
<div class="nav-items-wrapper <?php print $classes; ?>">

  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php /* if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif;*/ ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <div class="nav-dropdown nav-top">
    <?php print l( date("F", mktime(0, 0, 0, $view->display_month, 10)),'<front>', array('attributes' => array('class' => array('btn-dropdown')))); ?>
    <div class="nav-dropdown-inner">
      <table class="list-month table">
        <tbody><tr>
        <?php for ($i = 1; $i <= 12; $i++): ?>
          <?php $month_class = ''; if( (int)$i == (int)$view->display_month){ $month_class = 'active'; } ?>
          <td><?php print l(date('M', mktime(0, 0, 0, $i, 10)), OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_PARK_CALENDAR_MOBILE_PAGE_PATH . '/' . $view->display_year . '-' . $i, array('attributes' => array('class' => array($month_class))) ); ?></td>
          <?php if ( $i % 4 == 0): ?>
            </tr><tr>
          <?php endif; ?>
        <?php endfor; ?>
        </tr>
        </tbody>
      </table>
    </div>
  </div>

  <?php if ($rows): ?>
    <div class="nav-item">
      <ul class="nav-list">
      <?php print $rows; ?>
      </ul>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

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
  <div class="fixed-nav-bottom">
    <div class="nav-year nav-bottom">
      <?php print $view->next_year; ?>
      <span class="item-year"><?php print $view->display_year; ?></span>
      <?php print $view->prev_year; ?>
    </div>
  </div>

</div><?php /* class view */ ?>
