<?php

/**
 * @file
 */

namespace Drupal\superinfo\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
   $SuperinfoContentGenerator = new SuperinfoContentGenerator();
   $SuperinfoContentGenerator->superinfoTable();
 */
class SuperinfoContentGenerator extends ControllerBase {

  /**
   *
   */
  public function superinfoTable() {
    $output = '';
    $output .= '<div id="pageInfoBase" data-ng-app="pageInfoBase" class="custom-pageinfo pageinfo-subpage-common">';
      $output .= '<div data-ng-controller="PageInfoBaseController" class="row margin-0">';

        $output .= '<div class="block-one bg-ffffff margin-top-16">';
          $output .= '<div class="">';

            $output .= '<div class="">';
              $output .= '<div class="float-left">';
                $output .= t('Search') . ' <input data-ng-model="inputFilter.$">';
              $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="margin-top-12">';
              $output .= '<table class="table table-hover table-responsive">';
                $output .= '<thead>';
                  $output .= '<tr>';
                    $output .= '<th data-ng-repeat="(tableHeadKey, tableHeadCell) in pageData[0]">';
                      $output .= "{{ tableHeadKey }}";
                    $output .= '</th>';
                  $output .= '</tr>';
                $output .= '</thead>';

                $output .= '<tbody data-ng-repeat="tableRow in pageData | filter:inputFilter" class="">';
                  $output .= '<tr>';
                    $output .= '<td data-ng-repeat="tableRowCell in tableRow">';
                      $output .= '<span data-ng-bind-html="$sce.trustAsHtml(tableRowCell)">{{ tableRowCell }}</span>';
                    $output .= '</td>';
                  $output .= '</tr>';

                $output .= '</tbody>';
              $output .= '</table>';
            $output .= '</div>';

          $output .= '</div>';
        $output .= '</div>';

      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

}
