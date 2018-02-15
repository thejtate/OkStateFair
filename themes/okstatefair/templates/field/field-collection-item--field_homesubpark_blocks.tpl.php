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
<?php
if (isset($content['field_homesubpark_blocks_link']))
  print l(theme('image', array('path' => $content['field_homesubpark_blocks_image']['#items']['0']['uri'])), $content['field_homesubpark_blocks_link']['#items']['0']['display_url'], array('html' => TRUE, 'attributes' => array('class' => array('btn'))));
else { ?>
  <span class="btn btn-right">
    <span class="coming-triangle">
      <?php print theme('image', array('path' => drupal_get_path('theme', 'okstatefair') . '/images/tmp/com-yel.png')); ?>
    </span>
    <?php print theme('image', array('path' => $content['field_homesubpark_blocks_image']['#items']['0']['uri'])); ?>
  </span>
<?php } ?>
