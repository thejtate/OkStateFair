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
$title_disable = '';
//need move to preprocess_view

if (isset ($_GET['field_vendors_category_tid'])) {
  $title_disable = 'with-title';
  $term = taxonomy_term_load($_GET['field_vendors_category_tid']);
  $image_name = 'hunger_specialists.jpg';
}

if (isset ($_GET['bacon'])) {
  $title_disable = 'with-title';
  $term = taxonomy_term_load($_GET['field_vendors_category_tid']);
  $image_name = 'bacon_specialists.jpg';
}
if (isset ($_GET['deep_fried'])) {
  $title_disable = 'with-title';
  $term = taxonomy_term_load($_GET['field_vendors_category_tid']);
  $image_name = 'deep_fried.jpg';
}
if(isset ($_GET['on_a_stick'])) {
  $title_disable = 'with-title';
  $term = taxonomy_term_load($_GET['field_vendors_category_tid']);
  $image_name = 'on_a_stick_specialists.jpg';
}
if (isset($term))
  $name = $term->name;
else $name = '';
?>
<?php if(!empty($no_food_finder_access)): ?>
  <div class="food-finder-coming-soon">
    <?php print isset($check_back_image) ? $check_back_image : ''; ?>
  </div>
<?php else: ?>
<div class="bg-header"></div>

  <?php if ($exposed): ?>
      <?php print $exposed; ?>
  <?php endif; ?>

<div class="<?php //print $classes; ?>">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>
  <div class=" content-wrapper">
    <?php if ($rows): ?>
    <div class="view-content with-sidebar">
        <div class="left-filter <?php print $title_disable; ?>">
          <?php if (!$title_disable == '') : ?>
            <div class="view-title">
              <h3>Showing</h3>
              <h4><?php print $name; ?></h4>
            </div>
          <?php endif; ?> 
          <?php print $rows; ?>
        </div>
        <div class="view">
          <img src="/<?php print drupal_get_path('theme', 'okstatefair'); ?>/images/food/<?php print $image_name; ?>"/>
          <div class="btn-zoom">
              <div class="icon"></div>
              <a class="open-big-image" href="#"><?php print t('Just a little bigger, please.'); ?></a>
            </div>
          <div class="btn-close"></div>
        </div>
      </div>
    <?php elseif ($empty): ?>
      <div class="view-empty">
        <?php print $empty; ?>
        <img src="/<?php print drupal_get_path('theme', 'okstatefair');?>/images/food/food-no-results.jpg" />
      </div>
    <?php else :?>
      <img src="/<?php print drupal_get_path('theme', 'okstatefair');?>/images/food/food-no-results.jpg" />
    <?php endif; ?>
  </div>
  <?php if ($pager): ?>
    <?php print $pager; ?>
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
  
    <div class="bottom-filter">
      <hr class="clearfix"/>
      <div class="border-top"></div>
      <?php print $view->food_custom_block; ?>
    </div>
  
</div><?php /* class view */ ?>
<?php endif; ?>
