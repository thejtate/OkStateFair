<?php
/**
 * @file
 * Default theme implementation for field collection items.
 *
 * Available variables:
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $title: The (sanitized) field collection item label.
 * - $url: Direct url of the current entity if specified.
 * - $page: Flag for the full page state.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. By default the following classes are available, where
 *   the parts enclosed by {} are replaced by the appropriate values:
 *   - entity-field-collection-item
 *   - field-collection-item-{field_name}
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_entity()
 * @see template_process()
 */
?>
<div class="table-price">
  <?php print render($content['field_feed_bedding_table_title']); ?>
  <table class="table">
    <thead>
        <tr>
          <th class="col-price-1"><?php print $content['field_feed_bedding_table']['#items'][0]['tabledata'][0][0]; ?></td>
          <th class="col-price-2"><?php print $content['field_feed_bedding_table']['#items'][0]['tabledata'][0][1]; ?></td>   
          <th class="col-price-3"><?php print $content['field_feed_bedding_table']['#items'][0]['tabledata'][0][2]; ?></td>
        </tr>
    </thead>
    <?php unset($content['field_feed_bedding_table']['#items'][0]['tabledata'][0]); ?>
    <tbody>
      <?php foreach ($content['field_feed_bedding_table']['#items'][0]['tabledata'] as $key => $val): ?>
        <tr>
          <td><?php print $val[0]; ?></td>
          <td><?php print $val[1]; ?></td>   
          <td><?php print $val[2]; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php //print render($content['field_feed_bedding_table']); ?>
</div>