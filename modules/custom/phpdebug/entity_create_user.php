<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/entity_create_user.php');
  _run_batch_entity_create_user();
 */

function _run_batch_entity_create_user() {
  $entity_info = array(
    'entity_type' => 'user',  // 'node', 'taxonomy_term', 'user'
    'bundle' => 'client',
  );

  $users = _entity_user_info();
  foreach ($users as $user) {
    _entity_create_user_save($entity_info, $field);
  }
}

function _entity_user_info() {
  $users[] = array(
    'field_first_name' => 'Test First name',
    'fieldt_last_name' => 'Test Last name',
    'name' => 'test',
    'mail' => 'test@test.com',
    'roles' => array(),
    'pass' => 'password',
    'status' => 1,
  );

  return $users;
}

/**
 *
 */
function _entity_create_user_template() {
  $values = array(
    'name' => 'test',
    'mail' => 'test@test.com',
    'roles' => array(),
    'pass' => 'password',
    'status' => 1,
    'field_first_name' => 'Test First name',
    'fieldt_last_name' => 'Test Last name',
  );

  $account = entity_create('user', $values);
  $account->save();
}

