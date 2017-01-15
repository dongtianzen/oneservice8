
<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/export_from_d7/export_d7_term_from.php');
  _state_value(3);
 */

function _state_value($key = NULL) {
}

function taxonomyGetTreeTidNames($vid = NULL) {
  $output = array();


  $client_method_collections = _client_method_collections();
  if ($vid) {
    $terms = taxonomy_get_tree($vid);

    if (is_array($terms)) {
      foreach ($terms as $term) {
        $output[$term->tid] = $term->name;
        $term = taxonomy_term_load($term->tid);
        dpm($term);

        $row = array();
        foreach ($client_method_collections as $key => $value) {
          $row[] = $value;
        }
      }
    }
  }

  return $output;
}

function _client_method_collections() {
  $vid = 2;
  $methods = array(
    'field_client_address' => "field_client_contactaddress['und'][0]['safe_value']",
    'field_client_clienttype' => "field_client_clienttype['und'][0]['target_id']",
    'field_client_contactname' => "field_client_contactname['und'][0]['safe_value']",
    'field_client_email' => "field_client_contactemail['und'][0]['safe_value']",
    'field_client_phone' => "field_client_contactphone['und'][0]['safe_value']",
    'field_client_province' => "field_client_province['und'][0]['tid']",
    'field_client_salesperson' => "field_client_bundlesales['und'][0]['target_id']",
  );
}
