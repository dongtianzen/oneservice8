<?php

/**
 * @file
 * Contains Drupal\flexinfo\Service\FlexinfoSettingService.php.
 */
namespace Drupal\flexinfo\Service;

use Drupal\Component\Utility\Xss;

/**
 * An example Service container.
   $FlexinfoSettingService = new FlexinfoSettingService();
   $FlexinfoSettingService->setPageTitle();
 *
   \Drupal::getContainer()->get('flexinfo.setting.service')->setPageTitle();
 */
class FlexinfoSettingService {

  /**
   * use Drupal\Component\Utility\Xss;
   *
   * @return Xss::getAdminTagList() + custom tags
   *
   * \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag();
   */
  public function adminTag() {
    $admin_tags = Xss::getAdminTagList();
    $admin_tags_plus = [
      'button', 'canvas', 'custom-marker', 'form', 'info-window', 'input', 'label', 'map', 'marker', 'md-button', 'md-checkbox', 'md-content',
      'md-datepicker', 'md-icon', 'md-input-container', 'md-menu', 'md-menu-content',
      'md-option', 'md-select', 'md-select-header', 'md-slider', 'md-tab', 'md-tabs', 'md-tooltip', 'md-progress-circular',
    ];
    $admin_tags = array_merge($admin_tags, $admin_tags_plus);

    return $admin_tags;
  }

  /**
   * @param $pound_sign (#), #e6e6e6
     \Drupal::getContainer()->get('flexinfo.setting.service')->colorPlateOne();
   */
  public function colorPlateOne($pound_sign = FALSE, $key = NULL) {
    $plate_array = array(
      '1' => '56bfb5',
      '2' => 'f24b99',
      '3' => '344a5f',
      '4' => 'bfbfbf',
      '5' => 'e6e6e6',
    );

    $output = $this->colorPlateOutput($plate_array, $pound_sign, $key, 'f6f6f6');

    return $output;
  }

  /**
   * @param $pound_sign (#)
     \Drupal::getContainer()->get('flexinfo.setting.service')->colorPlateTwo();
   */
  public function colorPlateTwo($pound_sign = FALSE, $key = NULL) {
    $plate_array = array(
      '1' => '344a5f',
      '2' => '2fa9e0',
      '3' => '99dc3b',
      '4' => 'f24b99',
      '5' => '56bfb5',
      '6' => '5577fd',
      '7' => 'f3c848',
      '8' => '4fc1ff',
    );

    $output = $this->colorPlateOutput($plate_array, $pound_sign, $key);
    return $output;
  }

  /**
   *
   */
  public function colorPlateOutput($plate_array = array(), $pound_sign = FALSE, $key = NULL, $default = NULL) {
    $output = NULL;

    if ($pound_sign) {
      foreach ($plate_array as $key => $value) {
        $plate_array[$key] = '#' . $value;
      }
    }

    if ($key) {
      if (isset($plate_array[$key])) {
        $output = $plate_array[$key];
      }
      else {
        $output = $default;          // default color for not exist key request
        if ($default && $pound_sign) {
          $output = '#' . $default;
        }
      }
    }
    else {
      $output = $plate_array;
    }

    return $output;
  }

  /**
   * $timestamp = date_format(date_create($date_time, timezone_open('America/Toronto')), "U");
   *
   * @param 'html_date' is HTML Date like 2017-03-24
   \Drupal::getContainer()->get('flexinfo.setting.service')->convertTimeStampToHtmlDate();
   */
  public function convertTimeStampToHtmlDate($time_stamp, $type = 'html_date') {
    $output = \Drupal::service('date.formatter')->format($time_stamp, $type);

    return $output;
  }

  /**
   * @param 'html_date' is HTML Date like 2017-03-24
   \Drupal::getContainer()->get('flexinfo.setting.service')->convertTimeStampToQueryDate();
   */
  public function convertTimeStampToQueryDate($time_stamp) {
    $output = \Drupal::service('date.formatter')
      ->format($time_stamp, 'page_daytime', $format = '', $timezone = 'Europe/London');

    return $output;
  }

  /**
   *
   \Drupal::getContainer()->get('flexinfo.setting.service')->setPageTitle();
   */
  public function setPageTitle($title = NULL) {
    $request = \Drupal::request();
    if ($route = $request->attributes->get(\Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT)) {
      $route->setDefault('_title', $title);
    }
  }

}
