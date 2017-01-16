<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/entity_create_node_repair.php');
  _run_batch_entity_node_repair();
 */

use \Drupal\node\Entity\Node;

function _load_terms($term_name, $vocabulary = NULL) {
  $output = NULL;
  $terms = taxonomy_term_load_multiple_by_name($term_name, $vocabulary);
  if (count($terms) > 0) {
    $term = reset($terms);

    $output = $term->get('tid')->value;
  }

  return $output;
}

function _load_user($user_name) {
  $output = NULL;
  $user = user_load_by_name($user_name);

  if (count($user) > 0) {
    $output = $user->get('uid')->value;
  }

  return $output;
}

function _run_batch_entity_node_repair() {
  $nodes_info = json_decode(_entity_node_json_info(), true);
  foreach ($nodes_info as $node_info) {
    _entity_create_node_repair($node_info);
  }
}

function _entity_create_node_repair($node_info) {
  $bundle_type = 'repair';
  $language = \Drupal::languageManager()->getCurrentLanguage()->getId();

  $node = \Drupal\node\Entity\Node::create(array(
    'type' => $bundle_type,
    'title' => 'D7-' . '维修-' . $node_info['field_repair_client_name'] . '-' . $node_info['field_repair_serial_number'],
    'langcode' => $language,
    'uid' => 1,
    'status' => 1,

    // field
    'field_repair_clientname'    => _load_terms($node_info['field_repair_client_name']),
    'field_repair_clientsubname' => $node_info['field_repair_client_subname'],
    'field_repair_contactname'   => $node_info['field_repair_client_contactname'],
    'field_repair_contactphone'  => $node_info['field_repair_client_contactphone'],

    // 收取
    'field_repair_serialnumber'  => $node_info['field_repair_serial_number'],
    'field_repair_devicetype'    => _load_terms($node_info['field_repair_device_type']),
    'field_repair_deviceformat'  => $node_info['field_repair_device_spec'],
    'field_repair_receivenote'   => $node_info['field_repair_receive_note'],
    'field_repair_receivedate'   => $node_info['field_repair_receive_date'],

    // 初验
    'field_repair_checknote'     => $node_info['field_repair_check_note'],
    'field_repair_checkissue'    => $node_info['field_repair_check_issue'],
    'field_repair_checkstaff'    => _load_user($node_info['field_repair_check_staff']),
    'field_repair_checkdate'     => $node_info['field_repair_check_date'],
    'field_repair_quoteamount'   => $node_info['field_repair_quote_amount'],
    'field_repair_quotestatus'   => $node_info['field_repair_quote_status'],

    // 维修
    'field_repair_issuereason'   => $node_info['field_repair_issue_reason'],
    'field_repair_repairapproach' => $node_info['field_repair_repair_approach'],
    'field_repair_repairamount'  => $node_info['field_repair_repair_amount'],
    'field_repair_repairdate'    => $node_info['field_repair_repair_date'],

    // 返回
    'field_repair_returnamount'  => $node_info['field_repair_return_amount'],
    'field_repair_returnnote'    => $node_info['field_repair_return_note'],
    'field_repair_returndate'    => $node_info['field_repair_return_date'],
    'field_repair_warrantyday'   => $node_info['field_repair_warranty_day'],
  ));

  $node->save();
}

function _entity_node_json_info() {


  return $jsons;
}
