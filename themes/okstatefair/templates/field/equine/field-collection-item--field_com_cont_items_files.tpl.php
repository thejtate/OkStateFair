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
$type = isset($content['field_com_cont_items_files_type']['#items'][0]['value']) ?
  $content['field_com_cont_items_files_type']['#items'][0]['value'] : '';
$title = isset($content['field_com_cont_items_files_title']['#items'][0]['safe_value']) ?
  $content['field_com_cont_items_files_title']['#items'][0]['safe_value'] : '';
$url = '';

switch ($type) {
  case 'file':
    $url = isset($content['field_com_cont_items_files_file']) &&
    isset($content['field_com_cont_items_files_file']['#items'][0]['uri']) ?
      file_create_url($content['field_com_cont_items_files_file']['#items'][0]['uri']) : '';
    $class_not_active = !$url ? 'inactiveLink' : '';
    break;
  case 'link':
    $url = isset($content['field_com_cont_items_files_link']) &&
    isset($content['field_com_cont_items_files_link']['#items'][0]['url']) ?
      $content['field_com_cont_items_files_link']['#items'][0]['url'] : '';
    $class_not_active = !$url ? 'inactiveLink' : '';
    break;
  default:
    $class_not_active = 'inactiveLink';
    break;
}
?>

<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php print l($title, $url, array(
    'attributes' => array(
      'class' => array($class_not_active),
      'target' => '_blank',
    ),
    'html' => TRUE,
  )); ?>

  <?php hide($content['field_com_cont_items_files_type']); ?>
  <?php hide($content['field_com_cont_items_files_title']); ?>
  <?php hide($content['field_com_cont_items_files_file']); ?>
  <?php hide($content['field_com_cont_items_files_link']); ?>
  <?php print render($content); ?>
</div>