<?php
/**
 * @file
 * Template to display a view as a mini calendar month.
 * 
 * @see template_preprocess_calendar_mini.
 *
 * $day_names: An array of the day of week names for the table header.
 * $rows: An array of data for each day of the week.
 * $view: The view.
 * $min_date_formatted: The minimum date for this calendar in the format YYYY-MM-DD HH:MM:SS.
 * $max_date_formatted: The maximum date for this calendar in the format YYYY-MM-DD HH:MM:SS.
 * 
 * $show_title: If the title should be displayed. Normally false since the title is incorporated
 *   into the navigation, but sometimes needed, like in the year view of mini calendars.
 * 
 */
$params = array(
  'view' => $view,
  'granularity' => 'month',
  'link' => FALSE,
);
?>
<div class="cell-calendar-body">
  <table class="mini days"">
    <thead>
      <tr class="head">
        <?php foreach ($day_names as $cell): ?>
          <th class="<?php //print $cell['class']; ?>">
            <?php print $cell['data']; ?>
          </th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ((array) $rows as $row): ?>
        <tr>
          <?php foreach ($row as $cell): ?>
            <td id="<?php print $cell['id']; ?>" class="<?php print $cell['class']; ?> <?php print $cell['data'] ? 'disabled': ''; ?> <?php if(isset($view->exposed_input['chosen']) && $cell['id'] == ($view->name . '-' . $view->exposed_input['chosen'])) { print 'chosen-calendar-date'; }?>">
              <?php print $cell['data']; ?>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
