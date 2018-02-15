<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<ul class="color-point">
  <?php foreach ($rows as $id => $row): ?>
    <li class="blue-point">
      <?php print $row; ?>
    </li>
  <?php endforeach; ?>
</ul>