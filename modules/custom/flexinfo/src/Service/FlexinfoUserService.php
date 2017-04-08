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

  /**
   *
   */
  public function checkUserMailExist($user_mail = NULL) {
    $output = FALSE;

    if ($user_mail) {
      $user_uid = $this->getUidByMail($user_mail);
      if ($user_uid) {
        $output = TRUE;
      }
    }

    return $output;
  }

  /**
   *
   */
  public function checkUserNameExist($user_name = NULL) {
    $output = FALSE;

    if ($user_name) {
      $user_uid = $this->getUidByUserName($user_name);
      if ($user_uid) {
        $output = TRUE;
      }
    }

    return $output;
  }

  public function getUidByMail($mail = NULL) {
    $output = NULL;

    if ($mail) {
      $user = user_load_by_mail($mail);
      if ($user) {
        $output = $user->id();
      }
      else {
        if (\Drupal::currentUser()->id() == 1) {
          dpm('not found this user email  - ' . $mail . ' - getUidByMail()');
        }
      }
    }

    return $output;
  }

  public function getUidByUserName($user_name = NULL) {
    $output = NULL;

    if ($user_name) {
      $user = user_load_by_name($user_name);
      if ($user) {
        $output = $user->id();
      }
      else {
        if (\Drupal::currentUser()->id() == 1) {
          dpm('not found this user name - ' . $user_name . ' - getUidByUserName()');
        }
      }
    }

    return $output;
  }

  /**
   * @return user name
   */
  public function getUserNameByUid($uid = NULL) {
    $output = NULL;

    if ($uid) {
      $user = \Drupal::entityTypeManager()->getStorage('user')->load($uid);
      if ($user) {
        $output = $user->getUsername();
      }
    }

    return $output;
  }

  /** - - - - - - Field - - - - - - - - - - - - - - - - - - - - - - - - - -  */
}
