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
    $output .= '<nav class="navbar navbar-default container padding-0 max-width-inherit width-inherit">';

      $output .= '<div class="navbar-second-wrapper height-48 float-left width-pt-100 clear-both">';
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
    $user_start_time = '2017-01-01';
    $user_end_time = '2017-05-01';

    $output = '';
    $output .= '<div class="">';
      $output .= '<span class="pull-left float-left">';
        $output .= '<span class="header-page-title-wrapper margin-left-60 margin-top-12 font-size-15 color-fff float-left">';
          $output .= $page_title;
        $output .= '</span>';
      $output .= '</span>';

      $output .= '<span class="pull-right last">';
        $output .= '<div id="reportrange-header" class="pull-right margin-top-8 margin-right-48 line-height-32">';
          $output .= '<span class="font-size-14 padding-12 color-fff padding-left-24">';
            $output .= '<i class="glyphicon glyphicon-calendar fa fa-calendar fa-6 padding-right-10"></i>';
          $output .= '</span>';
          $output .= '<span class="naveinfo-date-block">' . $user_start_time . ' - ' . $user_end_time . ' </span>';
        $output .= '</div>';
      $output .= '</span>';
    $output .= '</div>';

    return $output;
  }

}