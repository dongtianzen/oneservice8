<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/entity_create_term.php');
  _load_terms();
  _run_batch_entity_create_terms();
 */

use Drupal\taxonomy\Entity\Term;

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

function _run_batch_entity_create_terms() {
  $vocabulary = array(
    'vid'  => 'client',
  );

  $terms = _entity_terms_info();
  foreach ($terms as $term_info) {
    _entity_create_terms($vocabulary, $term_info);
  }
}

function _entity_create_terms($vocabulary, $term_info) {
  $term = Term::create([
    'name' => $term_info[0],
    'vid'  => $vocabulary['vid'],
    'field_client_address' => $term_info[1],
    'field_client_clienttype' => _load_terms($term_info[2]),
    'field_client_contactname' => $term_info[3],
    'field_client_email' => $term_info[4],
    'field_client_phone' => $term_info[5],
    'field_client_province' => _load_terms($term_info[6]),
    'field_client_salesperson' => _load_user($term_info[7]),
  ]);
  $term->save();
}

function _entity_terms_info() {
  $terms = array(
    array("上海影音系统有限公司", "上海影音系统有限公司", "", "许亮", "", "13900000000", "上海", "zhangsan"),
  );

  return $terms;
}
