<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/export_from_d7/export_user_from_d7.php');
  _load_user_print_info();
 */

function _load_user_print_info() {
  // get all user object
  $users = entity_load('user');

  foreach ($users as $user) {
    if ($user->uid > 1) {
      dpm('array("name" => "' . $user->name . '", "email" =>"' . $user->mail . '"),');
    }
  }
}
