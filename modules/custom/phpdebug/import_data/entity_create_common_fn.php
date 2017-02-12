<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/import_data/entity_create_common_fn.php');
 */

/**
 * @return, term tid
 */
function _load_terms($term_name, $vocabulary = NULL) {
  $output = NULL;
  $terms = taxonomy_term_load_multiple_by_name($term_name, $vocabulary);
  if (count($terms) > 0) {
    $term = reset($terms);

    $output = $term->get('tid')->value;
  }

  return $output;
}

/**
 * @return, user uid
 */
function _load_user($user_name) {
  $output = NULL;

  if ($user_name) {
    $user = user_load_by_name($user_name);
    if (count($user) > 0) {
      $output = $user->get('uid')->value;
    }
  }

  return $output;
}
