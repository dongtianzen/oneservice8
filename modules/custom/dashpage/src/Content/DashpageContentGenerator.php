<?php

/**
 * @file
 */

namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 $DashpageContentGenerator = new DashpageContentGenerator();
 $DashpageContentGenerator->angularPage();
 */
class DashpageContentGenerator extends ControllerBase {

  /**
   *
   */
  public function clientList() {
    $DashpageBlockGenerator = new DashpageBlockGenerator();

    $output = '';
    $output .= '<div id="pageInfoBase" data-ng-app="pageInfoBase" class="custom-pageinfo pageinfo-subpage-common">';
      $output .= '<div data-ng-controller="PageInfoBaseController" class="row margin-top-16">';

        $output .= '<div class="block-one bg-ffffff padding-bottom-20">';
          $output .= '<div class="row">';
            $output .= $DashpageBlockGenerator->topWidgetsFixed();
          $output .= '</div>';
        $output .= '</div>';

        $output .= '<div id="charts-section" class="block-three row tab-content-block-wrapper">';
          $output .= '<div data-ng-repeat="block in landingPageData.contentSection">';
            $output .= '<div class="{{block.class}}">';
              $output .= $DashpageBlockGenerator->contentBlockMaster();
            $output .= '</div>';
          $output .= '</div>';
        $output .= '</div>';

      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

}
