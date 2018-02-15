<?php
/**
 * @file
 * Default simple view template to display a list of summary lines.
 *
 * @ingroup views_templates
 */
$years = array();
?>
<?php
foreach ($rows as $id => $row):
  $year = date('Y', strtotime($row->field_press_date_value_summary));
  $rows[$id]->field_press_date_value_summary = $year;
  $years[$id] = $year;
endforeach;

$years = array_unique($years);
$i = 0;
$curr = $years[$i];
$years = array_values($years);
$year = FALSE;
?>
<ul class="dropdown">
  <?php foreach ($rows as $id => $row): ?>
    <?php if ($curr == $row->field_press_date_value_summary && $year != TRUE) : ?>
      <?php
      print '<li>' . l($curr . '<span class="close"></span>', 'javascript:void();', array('external' => TRUE, 'html' => TRUE)) . '<ul>';
      $year = TRUE;
    elseif ($curr != $row->field_press_date_value_summary) :
      $i = $i + 1;
      $curr = $years[$i];
      print '</li></ul><li>' . l($curr . '<span class="close"></span>', 'javascript:void();', array('external' => TRUE, 'html' => TRUE)) . '<ul>';
      ?> 
    <?php endif; ?>
    <li>
      <?php if (!empty($options['count'])): ?>
        (<?php print $row->count ?>)
      <?php endif; ?>
      <a href="<?php print $row->url; ?>"<?php print !empty($row_classes[$id]) ? ' class="' . $row_classes[$id] . '"' : ''; ?>><?php print $row->link; ?></a>
      
    </li>
  <?php endforeach; ?>
</ul>
