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

  /**
   *
   \Drupal::getContainer()->get('flexinfo.user.service')->getUserRolesFromUid($uid);
   */
  public function getUserRolesFromUid($uid = NULL, $authenticated = FALSE) {
    $user = \Drupal::entityTypeManager()->getStorage('user')->load($uid);
    return $this->getUserRolesFromUserObj($user, $authenticated);
  }

  /**
   *
   */
  public function getUserRolesFromUserObj($user = NULL, $authenticated = FALSE) {
    $role_names = array();
    if ($user) {
      if ($user->id() > 0) {

        $roles = $user->getRoles();
        if ($roles && is_array($roles)) {

          foreach ($roles as $key => $value) {

            if (!$authenticated) {
              if ($value == 'authenticated') {
                continue;
              }
            }

            $role_names[] = $value;
          }
        }
      }
    }

    return $role_names;
  }

  /**
   * @return boolean
   \Drupal::getContainer()->get('flexinfo.user.service')->checkUserHasSpecificRolesFromUid($valid_roles, $uid);
   */
  public function checkUserHasSpecificRolesFromUid($valid_roles = array(), $uid = NULL, $authenticated = FALSE) {
    $user_roles = $this->getUserRolesFromUid($uid, $authenticated);
    $matches_array = array_intersect($valid_roles, $user_roles);

    if ($matches_array) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }


  /** - - - - - - Field - - - - - - - - - - - - - - - - - - - - - - - - - -  */
}
