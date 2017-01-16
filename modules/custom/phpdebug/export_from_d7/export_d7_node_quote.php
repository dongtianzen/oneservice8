<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/export_from_d7/export_d7_node_repair.php');
 */

_export_d7_node_quote();
function _export_d7_node_quote() {
  $output = array();

  $node_method_collections = _node_method_collections();
  $nids = _specifyBundleNid(array('quote'));
  $nodes = node_load_multiple($nids);
  dpm(count($nodes));

  if (is_array($nodes)) {
    foreach ($nodes as $key => $node) {
      $row = array();
      foreach ($node_method_collections as $field_name => $value) {

        $field_value = NULL;
        if (isset($node->{$field_name}['und'][0][$value])) {
          $field_value = $node->{$field_name}['und'][0][$value];

          if ($value == "tid" || $value == "target_id") {
            $term = taxonomy_term_load($node->{$field_name}['und'][0][$value]);
            if (isset($term->name)) {
              $field_value = $term->name;
            }

            if ($field_name == "field_quote_check_staff") {
              $user = user_load($node->{$field_name}['und'][0][$value]);
              if (isset($user->name)) {
                $field_value = $user->name;
              }
            }
          }
        }
        // dpm($field_name . ' - ' . $field_value);
        $row[$field_name] = $field_value;
      }

      // dpm('array(' . implode(',', $row) . '),');
      $output[] = $row;
    }

    $json_data = json_encode($output, JSON_UNESCAPED_UNICODE);
    dpm($json_data);
  }

  return $output;
}

function _specifyBundleNid($node_type = array()) {
    $query = new EntityFieldQuery;
    $query->entityCondition('entity_type', 'node')
      ->entityCondition('bundle', $node_type)
      ->propertyCondition('status', NODE_PUBLISHED);

    $result = $query->execute();
    $nid_array = NULL;
    if (isset($result['node'])) {
      if (count($result['node']) > 0 ) {
        $nid_array = array_keys($result['node']);
      }
    }

    return $nid_array;
}

function _node_method_collections() {
  $methods = array(
    // 'field_text'             => "safe_value",
    // 'field_entity_reference' => "target_id",
    // 'field_term_reference'   => "tid",
    // 'field_datetime'         => "value",

    'field_quote_repair_nid'      => "value",
    'field_quote_company_name'    => "target_id",
    'field_quote_client_name'     => "safe_value",
    'field_quote_sum_price'       => "value",
    'field_quote_warranty_day'    => "value",
    'field_quote_create_date'     => "value",
    'field_quote_authorize_stamp' => "value",
  );

  return $methods;
}
