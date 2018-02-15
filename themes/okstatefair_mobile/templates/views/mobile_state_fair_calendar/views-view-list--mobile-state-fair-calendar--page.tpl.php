<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates
 */
?>
<?php print $wrapper_prefix; ?>
  <?php if (!empty($title)) : ?>
    <div <?php print $title_id ? 'id="' . $title_id . '"' : '' ; ?> class="nav-date-title">
      <h3><?php print $title; ?></h3>
    </div>
  <?php endif; ?>

<ul class="nav-list">
    <?php foreach ($rows as $id => $row): ?>
    <li class=" <?php print $classes_array[$id]; ?>"><?php print $row; ?></li>
    <?php endforeach; ?>
</ul>
<?php print $wrapper_suffix; ?>