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
    'title' => 'D7 ' . '维修' . $node_info['field_repair_client_name'] . '-' . $node_info['field_repair_serial_number'],
    'langcode' => $language,
    'uid' => 1,
    'status' => 1,

    // field
    // 'field_repair_clientname' => $node_info['field_repair_client_name'],

    // 收取
    // 'field_repair_serial_number' => $node_info['field_repair_serial_number'],
    // 'field_client_province' => _load_terms($term_info[6]),
    // 'field_client_salesperson' => _load_user($term_info[7]),
  ));

  $node->save();
}

function _entity_node_json_info() {
  $jsons = '';

  return $jsons;
}
