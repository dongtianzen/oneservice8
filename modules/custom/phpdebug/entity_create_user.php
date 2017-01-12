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
 * \Drupal\user\Entity\User::create();
 */
function _entity_create_user_save() {
  $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
  $user = \Drupal\user\Entity\User::create();

  // Mandatory settings
  $user->setUsername('user_name');  // This username must be unique and accept only a-Z,0-9, - _ @ .
  $user->setPassword('password');
  // $user->setPassword(user_password());   // automatically set a password with the code

  $user->setEmail('email');
  $user->enforceIsNew();        // Set this to FALSE if you want to edit (resave) an existing user object

  // Optional settings
  $user->set("init", 'email');
  $user->set("langcode", $language);
  $user->set("preferred_langcode", $language);
  $user->set("preferred_admin_langcode", $language);

  // $user->set("setting_name", 'setting_value');
  $user->activate();

  // Save user
  $res = $user->save();

  //
  $uid = $user->id();

  // If you want to send welcome email with out admin approval you can use after user save
  // _user_mail_notify('register_no_approval_required', $user);

}

/**
 * update
 */
function _update_user_template($content) {
  use Drupal\user\Entity\User;

  // Load user with user ID
  $user = User::load($uid);

  // Load the current user.
  $user = \Drupal::currentUser();
  $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());

  // Update email Id
  $user->setEmail($content['email']);

  // Update username
  $user->setUsername($content['email']);

  // Update password reset
  $user->setPassword($content['password']);

  // user role
  $user->addRole('administrator');
  $user->removeRole('administrator');

  // For User field
  $user->set("field_first_name", $firstName);
  $user->set("field_last_name", $lastName);

  //Save user
  $userss = $user->save();

  //Where "$content" array contains all user profile data
}

/**
 * load
 */
function _load_user_template() {
  // Load the current user.
  $user = \Drupal::currentUser();
  $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());

  // get field data from that user
  $website = $user->get('field_website')->value;
  $body = $user->get('body')->

  $email = $user->get('mail')->value;
  $name = $user->get('name')->value;
  $uid= $user->get('uid')->value;
}


/**
 * entity_create()
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

