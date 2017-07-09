<?php

/**
 * @file
 */

namespace Drupal\manageinfo\Content;

use Drupal\Core\Controller\ControllerBase;

use Drupal\Core\Url;

/**
 * An example controller.
 $ ManageinfoContentGenerator = new ManageinfoContentGenerator();
 $ ManageinfoContentGenerator->angularForm();
 */
class ManageinfoContentGenerator extends ControllerBase {

  /**
   *
   */
  public function settingIndex() {
    $setting_array = array(
      array(
        'url' => '/superinfo/client/table/all',
        'name' => 'Client',
      ),
      array(
        'url' => '/superinfo/client_type/table/all',
        'name' => 'Client Type',
      ),
      array(
        'url' => '/superinfo/company/table/all',
        'name' => 'Company',
      ),
      array(
        'url' => '/superinfo/device_type/table/all',
        'name' => 'Device Type',
      ),
      array(
        'url' => '/superinfo/notification/table/all',
        'name' => 'Notification',
      ),
      array(
        'url' => '/superinfo/province/table/all',
        'name' => 'Province',
      ),
      array(
        'url' => '/superinfo/user/table/all',
        'name' => 'User',
      ),
    );

    $output = '';
    $output .= '<div class="row margin-0">';
      foreach ($setting_array as $row) {
        $url = Url::fromUserInput($row['url']);

        $output .= '<div class="col-md-4 col-sm-6 col-xs-12 margin-top-20">';
          $output .= '<span class=""><i class="fa fa-television" aria-hidden="true"></i></span>';
          $output .= '<span class="margin-left-12">' . $this->l($row['name'], $url) . '</span>';
        $output .= '</div>';
      }
    $output .= '</div>';

    return $output;
  }

}
