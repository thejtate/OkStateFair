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
//kpr($content['field_homesub_blocks_visible']['#items']);
?>
<?php
if ($content['field_homesub_blocks_visible']['#items']['0']['value'] == '1') :

  if (isset($content['field_homesubpark_blocks_link'])) {
    $img_link = $content['field_homesubpark_blocks_link']['#items']['0']['display_url'];
    print l(theme('image', array('path' => $content['field_homesubpark_blocks_image']['#items']['0']['uri'])), $img_link, array(
      'html' => TRUE,
      'external' => TRUE,
      'attributes' => array('class' => array('btn'))
    ));

  }
  else {
    if (isset($content['field_homesub_blocks_triangle'])) {
      $coming = '<span class="coming-triangle">' .
        theme('image', array('path' => drupal_get_path('theme', 'okstatefair') . '/images/tmp/' . $content['field_homesub_blocks_triangle']['#items']['0']['value'] . '.png')) .
        '</span>';
      print '<span class="btn">' . $coming . theme('image', array('path' => $content['field_homesubpark_blocks_image']['#items']['0']['uri'])) . '</span>';

    }
    else {
      print '<span class="btn">' . $coming . theme('image', array('path' => $content['field_homesubpark_blocks_image']['#items']['0']['uri'])) . '</span>';
    }
  }
else :
  ?>
  <span class="hideme"></span>
<?php

endif;
?>
