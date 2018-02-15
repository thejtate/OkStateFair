<?php
/**
 * @file field.tpl.php
 * Default template implementation to display the value of a field.
 *
 * This file is not used and is here as a starting point for customization only.
 * @see theme_field()
 *
 * Available variables:
 * - $items: An array of field values. Use render() to output them.
 * - $label: The item label.
 * - $label_hidden: Whether the label display is set to 'hidden'.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - field: The current template type, i.e., "theming hook".
 *   - field-name-[field_name]: The current field name. For example, if the
 *     field name is "field_description" it would result in
 *     "field-name-field-description".
 *   - field-type-[field_type]: The current field type. For example, if the
 *     field type is "text" it would result in "field-type-text".
 *   - field-label-[label_display]: The current label position. For example, if
 *     the label position is "above" it would result in "field-label-above".
 *
 * Other variables:
 * - $element['#object']: The entity to which the field is attached.
 * - $element['#view_mode']: View mode, e.g. 'full', 'teaser'...
 * - $element['#field_name']: The field name.
 * - $element['#field_type']: The field type.
 * - $element['#field_language']: The field language.
 * - $element['#field_translatable']: Whether the field is translatable or not.
 * - $element['#label_display']: Position of label display, inline, above, or
 *   hidden.
 * - $field_name_css: The css-compatible field name.
 * - $field_type_css: The css-compatible field type.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess_field()
 * @see theme_field()
 *
 * @ingroup themeable
 */

//how many years to show. if more than one, display them,
$only_one_year = TRUE;
$year = NULL;
foreach ($items as $delta => $item){
  $date = each($item['entity']['field_collection_item']);
  if( !empty($year) &&
    $year != date('Y', strtotime($date['value']['field_sfp_event_dates_date']['#items'][0]['value']))){
    $only_one_year = FALSE;
  }
  $year = date('Y', strtotime($date['value']['field_sfp_event_dates_date']['#items'][0]['value']));
}
?>
<?php if ($element['#view_mode'] == 'full'): ?>
  <table class="table-type-2 table">
    <thead>
      <tr class="table-header">
        <th colspan="3">Event Schedule</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $delta => $item): ?>
        <?php $date = each($item['entity']['field_collection_item']); ?>
        <?php if( !$only_one_year &&
          !empty($item['entity']['field_collection_item'][$date['key']]['field_sfp_event_dates_date']['#items'][0]['value']) &&
          $min_year != date('Y', strtotime($item['entity']['field_collection_item'][$date['key']]['field_sfp_event_dates_date']['#items'][0]['value']))): ?>
          <?php $min_year = date('Y', strtotime($item['entity']['field_collection_item'][$date['key']]['field_sfp_event_dates_date']['#items'][0]['value'])); ?>
          <tr class="year">
            <td colspan="3" ><b><?php print $min_year; ?><b></td>
          </tr>
          <tr>
            <?php print render($item); ?>
          </tr>
        <?php else: ?>
          <tr>
            <?php print render($item); ?>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
<?php endif; ?>