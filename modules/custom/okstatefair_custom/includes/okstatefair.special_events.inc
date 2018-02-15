<?php
/**
* @file
* Project titles
*/
function chickasaw_nodes() {
  $chickasaw_nodes = range('1545', '1550');
//  $chickasaw_nodes[] = 1541;
  $chickasaw_nodes[] = 1542;
  for ($i = 11508; $i < 11515; $i++) {
    $chickasaw_nodes[] = $i;
  }
  $chickasaw_nodes[] = 1543;
  $chickasaw_nodes[] = 1946;
  $chickasaw_nodes[] = 3791;
  $chickasaw_nodes[] = 1959;
  $chickasaw_nodes[] = 14989;
  $chickasaw_nodes[] = 14988;
  $chickasaw_nodes[] = 14992;
  $chickasaw_nodes[] = 14993;
  $chickasaw_nodes[] = 14994;
  $chickasaw_nodes[] = 14995;
  $chickasaw_nodes[] = 14996;
  $chickasaw_nodes[] = 14997;
  $chickasaw_nodes[] = 14998;
  $chickasaw_nodes[] = 14999;
  $chickasaw_nodes[] = 15000;
//  $chickasaw_nodes[] = 15001;
  $chickasaw_nodes[] = 15002;
//  $chickasaw_nodes[] = 15003;
  $chickasaw_nodes[] = 15004;
  $chickasaw_nodes[] = 15154;
  return $chickasaw_nodes;
}

/**
 * For Special nodes only dates will be replaced on Excel import
 */
function okstatefair_event_special_nodes() {
  $special = chickasaw_nodes();
  $special[] =  DISNEP_NID;
  $special[] =  DISNEP_NEW_NID;
  $special[] =  XTREME_BULLS;
  $res = array_merge($special, private_events());
  return $res;
}

function private_events() {
  $private_events[] = 2194;
  $private_events[] = XTREME_CLAY;
  $private_events[] = XTREME_NEW;
  $private_events[] = XTREME_JN;
  $private_events[] = XTREME_JOSH;
  $private_events[] = XTREME_MONTGOMERY_GENTRY;
  $private_events[] = XTREME_ELI_YOUNG_BAND;
  return $private_events;
}

function okstatefair_is_event_special_node($nid) {
  $special_nodes = okstatefair_event_special_nodes();
  $special_performer = _okstate_special_performer(node_load($nid));
  return in_array($nid, $special_nodes) || $special_performer;
}

/**
 * Skip this nids on Excel import
 */
function okstatefair_event_skip_import_node() {
  $skip_nids = private_events();
  $skip_nids[] = XTREME_BULLS;
  return $skip_nids;
}

function okstatefair_is_event_skip_import_node($nid) {
  $skip_nids = okstatefair_event_skip_import_node();
  return in_array($nid, $skip_nids);
}

function okstatefair_check_disnep_nid($nid) {
  $skip_nids = array(DISNEP_NID, DISNEP_NEW_NID);
  return in_array($nid, $skip_nids);
}

function okstatefair_disnep_nodes() {
  $nodes = array('2013 MODE (LIVE)' => DISNEP_NID, '2014 MODE' => DISNEP_NEW_NID);
  return $nodes;
}

function _okstate_special_performer($node) {
  $field_special_performer = FALSE;

  if (!is_object($node)) {
    return;
  }
  try {
    $node_wrapper = entity_metadata_wrapper('node', $node);
    $properties = $node_wrapper->getPropertyInfo();

    if (array_key_exists('field_special_performer', $properties)) {
      $field_special_performer = $node_wrapper->field_special_performer->value();
    }
  }
  catch (EntityMetadataWrapperException $exc) {
    watchdog('okstate', 'See ' . __FUNCTION__ . '() <pre>' . $exc->getTraceAsString() . '</pre>', NULL, WATCHDOG_ERROR);
  }
  return $field_special_performer;
}
