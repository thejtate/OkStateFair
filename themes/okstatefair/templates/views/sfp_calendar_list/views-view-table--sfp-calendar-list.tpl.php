<?php

/**
 * @file
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $caption: The caption for this table. May be empty.
 * - $header_classes: An array of header classes keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $classes: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * - $field_classes: An array of classes to apply to each field, indexed by
 *   field id, then row number. This matches the index in $rows.
 * @ingroup views_templates
 */

$ulr_options = array();
//if(!empty($view->current_date)) {
//  $ulr_options = array('query' => array('m' => $view->current_date->format('Y-m')));
//}

?>
<div class="table-wrapper-events">

    <?php foreach ($rows as $row_count => $row): ?>
      <div class="row">
        <a href="<?php print url('node/' . $result[$row_count]->nid, $ulr_options)?>">
          <span class="date"><?php print $row['field_sfp_event_dates_date']?></span>
          <span class="title"><?php print $row['title']?></span>
        </a>
      </div>
    <?php endforeach; ?>

</div>
