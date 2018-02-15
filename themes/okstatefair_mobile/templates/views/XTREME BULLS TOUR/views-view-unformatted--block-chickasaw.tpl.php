<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<?php foreach ($rows as $id => $row): ?>
  <ul class="nav-list">
    <li>
      <?php print $row; ?>
    </li>

  </ul>
<?php endforeach; ?>