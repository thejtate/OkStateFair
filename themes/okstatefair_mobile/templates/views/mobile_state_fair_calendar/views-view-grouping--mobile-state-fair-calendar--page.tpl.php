<?php

/**
 * @file
 * This template is used to print a single grouping in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $grouping: The grouping instruction.
 * - $grouping_level: Integer indicating the hierarchical level of the grouping.
 * - $rows: The rows contained in this grouping.
 * - $title: The title of this grouping.
 * - $content: The processed content output that will normally be used.
 */
?>
<?php if(!empty($title)):?>
  <div class="nav-date-title .nav-date-title-featured">
    <h3><?php print t('Featured'); ?></h3>
  </div>
<?php endif;?>
<div class="nav-item view-grouping<?php print (!empty($title) ? ' featured-events' : '') ?>">
  <?php
  //Title contains Featured value 0 or 1
  ?>
  <div class="view-grouping-content">
    <?php print $content; ?>
  </div>
</div>
