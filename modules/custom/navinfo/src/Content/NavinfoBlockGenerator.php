<?php

/**
 * @file
 */

namespace Drupal\navinfo\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 use Drupal\navinfo\Content\NavinfoBlockGenerator;

 $NavinfoBlockGenerator = new NavinfoBlockGenerator();
 $NavinfoBlockGenerator->contentBlockCharts();
 */
class NavinfoBlockGenerator extends ControllerBase {

  /*
   * Content Block Header
   */
  function contentNavigation() {
    $output = '';
    $output .= '<nav class="navbar container margin-bottom-0 padding-0 max-width-inherit width-inherit">';
      $output .= '<div class="navbar-second-wrapper width-pt-100 clear-both">';
        $output .= $this->contentNavigationStatusbar();
      $output .= '</div>';
    $output .= '</nav>';

    return $output;
  }

  /**
   * Implements statusbar content
   */
  function contentNavigationStatusbar() {
    $page_title = '';

    $user_start_time = 'start';
    $user_end_time = 'end';

    $current_path = \Drupal::service('path.current')->getPath();
    $path_args = explode('/', $current_path);

    $start_boolean = \Drupal::getContainer()->get('flexinfo.setting.service')->isTimestamp($path_args[5]);
    $end_boolean = \Drupal::getContainer()->get('flexinfo.setting.service')->isTimestamp($path_args[6]);

    if ($start_boolean && $end_boolean) {
      $user_start_time = \Drupal::getContainer()->get('flexinfo.setting.service')->convertTimeStampToHtmlDate($path_args[5]);
      $user_end_time = \Drupal::getContainer()->get('flexinfo.setting.service')->convertTimeStampToHtmlDate($path_args[6]);
    }

    $output = '';
    $output .= '<div class="margin-top-n-8">';
      $output .= '<span class="pull-left float-left">';
        $output .= '<span class="header-page-title-wrapper margin-left-60 margin-top-12 font-size-15 float-left">';
          $output .= $page_title;
        $output .= '</span>';
      $output .= '</span>';

      $output .= '<span class="pull-right last">';
        $output .= '<div id="reportrange-header" class="pull-right margin-top-8 margin-right-48 line-height-32">';
          $output .= '<span class="font-size-14 padding-12 padding-left-24">';
            $output .= '<i class="fa fa-calendar fa-6"></i>';
          $output .= '</span>';
          $output .= '<span class="naveinfo-date-block">' . $user_start_time . ' - ' . $user_end_time . ' </span>';
        $output .= '</div>';
      $output .= '</span>';
    $output .= '</div>';

    return $output;
  }

}
