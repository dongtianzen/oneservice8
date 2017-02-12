<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/import_data/entity_create_user.php');
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/import_data/entity_create_common_fn.php');
  drupal_set_time_limit(0);
  _run_batch_entity_create_user();
 */

function _run_batch_entity_create_user() {
  $users_array = _fetch_convert_json();
  foreach ($users_array as $user_info) {
    _entity_create_user_save($user_info);
  }
}

/**
 * \Drupal\user\Entity\User::create();
 */
function _entity_create_user_save($user_info = array()) {
  $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
  $user = \Drupal\user\Entity\User::create();

  // Mandatory settings
  $user->setUsername($user_info['name']);
  $user->setPassword('your_password');

  $user->setEmail($user_info['email']);
  $user->enforceIsNew();                    // Set this to FALSE if you want to edit (resave) an existing user object

  // Optional settings
  // $user->set("init", 'email');
  // $user->set("langcode", $language);
  // $user->set("preferred_langcode", $language);
  // $user->set("preferred_admin_langcode", $language);

  // $user->set("setting_name", 'setting_value');
  $user->activate();

  if (is_array($user_info['roles'])) {
    foreach ($user_info['roles'] as $role_name) {
      if ($role_name != 'authenticated user') {
        $user->addRole($role_name);
      }
    }
  }

  if (is_array($user_info['field'])) {
    foreach ($user_info['field'] as $field_name => $value) {
      $field = \Drupal\field\Entity\FieldStorageConfig::loadByName('user', $field_name);

      if ($field->getType() == 'string') {
        $user_field_value[$field_name] = $value;
      }
      elseif ($field->getType() == 'entity_reference') {
        if ($field->getSetting('target_type') == 'taxonomy_term') {
          foreach ($value as $row_value) {
            $user_field_value[$field_name][] = _load_terms($row_value);
          }
        }
      }

      $user->set($field_name, $user_field_value[$field_name]);
    }
  }

  // Save user
  $res = $user->save();

  // return user uid
  $uid = $user->id();
  if ($uid > 0) {
    dpm('create user -' . $user_info['name'] . ' - uid - ' . $uid);
  }

}

function _fetch_convert_json() {
  global $base_url;
  $feed_url = $base_url . '/modules/custom/phpdebug/import_data/entity_create_user_json.json';

  $response = \Drupal::httpClient()->get($feed_url, array('headers' => array('Accept' => 'text/plain')));
  $data = $response->getBody();

  $output = json_decode($data, TRUE);
  return  $output;
}
