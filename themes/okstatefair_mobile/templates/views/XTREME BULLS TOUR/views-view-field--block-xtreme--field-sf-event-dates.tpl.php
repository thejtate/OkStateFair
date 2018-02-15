<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
$date = $view->result[$view->row_index]->field_field_sf_event_dates[0]['rendered']['entity']['field_collection_item'][$variables['view']->result[$view->row_index]->_field_data['nid']['entity']->field_sf_event_dates['und'][0]['value']]['field_sf_event_dates_date']['#items'][0]['value'];
if ($date != 0) {
  $timezone = new DateTimeZone(date_default_timezone_get());
  $curday_date = new DateTime($date, $timezone);
  $offset = $timezone->getOffset($curday_date);
  $curday_date = $curday_date->format('U') + $offset;
  $month = custom_month(date('M', $curday_date));
}
?>
<?php if ($date != 0) : ?>
  <span class="nav-date"><?php print $month . date('d', $curday_date); ?></span>
<?php endif; ?>

  