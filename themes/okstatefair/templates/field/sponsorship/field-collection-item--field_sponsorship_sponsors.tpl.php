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
<?php if (isset($content['field_coporate_sponsors_website'])) : ?>
  <figure class="img"><?php print l(render($content['field_coporate_sponsors_image']), $content['field_coporate_sponsors_website']['0']['#element']['url'], array('html' => TRUE)); ?></figure>
  <div class="description">
    <h5><?php print strip_tags(render($content['field_coporate_sponsors_descript']), '<strong><a><br><i>'); ?></h5>
  </div>
<?php else : ?>
  <figure class="img"><?php print render($content['field_coporate_sponsors_image']); ?></figure>
  <div class="description">
    <h5><?php print strip_tags(render($content['field_coporate_sponsors_descript']), '<strong><a><br><i>'); ?></h5>
  </div>
<?php endif; ?>
