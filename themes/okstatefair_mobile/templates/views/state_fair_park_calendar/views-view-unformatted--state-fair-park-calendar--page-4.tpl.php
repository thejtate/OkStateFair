<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<li class="item-events">
  <?php if(!empty($view->result[$view->row_index]->field_sfp_event_dates_field_collection_item_nid)): ?>
  <a href="<?php print url('node/' . $view->result[$view->row_index]->field_sfp_event_dates_field_collection_item_nid, array('query' => drupal_get_destination())); ?>" <?php if($has_target){ print 'class="event-target"'; } ?>>
    <div class="events">
    <?php if (!empty($title)): ?>
      <span class="nav-text-event"><?php print $view->result[$view->row_index]->field_sfp_event_dates_field_collection_item_title; ?></span>
    <?php endif; ?>
    </div>
    <span class="nav-date-event">
      <?php foreach ($rows as $id => $row): ?><?php print $row; ?><?php endforeach; ?>
    </span>
  </a>
  <?php endif; ?>
</li>
