<?php
/**
 * @file
 *  Contains helper page for rebuilding denormalized calendar table
 */

/**
 * Page callback form
 */
function okstatefair_calendar_batch_rebuild_form() {

  $old_wrong_ids = okstatefair_calendar_get_old_removed_ids();

  $form['description'] = array(
    '#type' => 'markup',
    '#markup' => t('Rebuild calendar denormalized table.'),
  );

  if(!empty($old_wrong_ids)) {
    $form['delete_wrong_ids'] = array(
      '#type' =>'checkbox',
      '#title' => t('Found @number wrong old items. Delete.', array('@number' => count($old_wrong_ids))),
    );

    $form['wrong_ids'] = array('#type' => 'value', '#value' => $old_wrong_ids);
  }

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Start rebuild table.',
  );

  return $form;
}

/**
 * Find wrong old ids in denormalized tables, that wasn't removed
 * by unknown reason.
 */
function okstatefair_calendar_get_old_removed_ids() {
  $query = db_select('state_fair_calendar', 'c')
    ->fields('c', array('id'));
  $query->leftJoin('field_data_field_sf_event_dates', 'd', 'c.id = d.field_sf_event_dates_value');
  $query->where('d.entity_id IS NULL');
  $result = $query->execute()
    ->fetchCol();
  return $result;
}

/**
 * Form submit
 */
function okstatefair_calendar_batch_rebuild_form_submit($form, &$form_state) {

  if(!empty($form_state['values']['delete_wrong_ids']) && !empty($form_state['values']['wrong_ids'])) {

    $num_deleted = db_delete('state_fair_calendar')
      ->condition('id', $form_state['values']['wrong_ids'], 'IN')
      ->execute();
    drupal_set_message(t('Deleted @num rows', array('@num' => $num_deleted)), 'status');
  }

  $field_collections_ids = db_select('field_data_field_sf_event_dates', 'd')
    ->fields('d', array('field_sf_event_dates_value'))
    ->execute()
    ->fetchCol();

  $num_operations = count($field_collections_ids);

  $operations = array();
  for ($i = 0; $i < $num_operations; $i++) {
    $operations[] = array('okstatefair_calendar_batch_operation', array($field_collections_ids[$i], t('(Operation @operation)', array('@operation' => $i))));
  }

  $batch = array(
    'operations' => $operations,
    'finished' => 'okstatefair_calendar_batch_finished',
    'title' => t('Processing batch'),
    'init_message' => t('Process is starting.'),
    'progress_message' => t('Processed @current out of @total.'),
    'error_message' => t('Batch 2 has encountered an error.'),
    'file' => drupal_get_path('module', 'okstatefair_calendar') . '/includes/okstatefair_calendar.helper.inc',
  );

  batch_set($batch);
}

/**
 * Batch finished
 */
function okstatefair_calendar_batch_finished($success, $results, $operations) {
  if ($success) {
    // Here we could do something meaningful with the results.
    // We just display the number of nodes we processed...
    drupal_set_message(t('@count results processed', array('@count' => count($results))));
    drupal_set_message(t('The final result was "%final"', array('%final' => end($results))));
  }
  else {
    // An error occurred.
    // $operations contains the operations that remained unprocessed.
    $error_operation = reset($operations);
    drupal_set_message(t('An error occurred while processing @operation with arguments : @args', array('@operation' => $error_operation[0], '@args' => print_r($error_operation[0], TRUE))));
  }
}

/**
 *
 */
function okstatefair_calendar_batch_operation($field_id, $operation_details, &$context) {

  $field_collection = field_collection_item_load($field_id);
  $node = $field_collection->hostEntity();
  $location = '';
  $location_tid = 0;
  if(!empty($node->field_sf_event_location[LANGUAGE_NONE][0]['tid'])) {
    $location_tid = $node->field_sf_event_location[LANGUAGE_NONE][0]['tid'];
    $term = taxonomy_term_load($location_tid);
    $location = !empty($term->name) ? $term->name : '';
  }

  $record = array(
    'id' => $field_collection->item_id,
    'nid' => $node->nid,
    'title' => $node->title,
    'start_date_time'=> $field_collection->field_sf_event_dates_date[LANGUAGE_NONE][0]['value'],
    'location' => $location,
    'location_tid' => $location_tid,
  );

  db_merge('state_fair_calendar')
    ->key(array('id' => $record['id']))
    ->fields($record)
    ->execute();

  $context['results'][] = 'field Id: ' . $field_id  . ' ' . $operation_details;

  $context['message'] = 'Processing Id: ' . $field_id  . ' Event: ' . $node->title;

}