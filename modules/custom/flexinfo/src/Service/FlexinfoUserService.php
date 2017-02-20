<?php

/**
 * @file
 * Contains Drupal\flexinfo\Service\FlexinfoUserService.php.
 */
namespace Drupal\flexinfo\Service;

/**
 * An example Service container.
  \Drupal::getContainer()->get('flexinfo.user.service')->getUserNameByUid($uid);
 */
class FlexinfoUserService {

  public function getUidByUserName($user_name = NULL) {
    $output = NULL;

    if ($user_name) {
      $user = user_load_by_name($user_name);
      if (count($user) > 0) {
        $output = $user->get('uid')->value;
      }
    }

    return $output;
  }

  /**
   * @return user name
   */
  public function getUserNameByUid($uid = NULL) {
    $output = NULL;

    $account = \Drupal\user\Entity\User::load($uid);
    if ($account) {
      $output = $account->getUsername();
      $output = $account->get('name')->value;
    }

    return $output;
  }

}
