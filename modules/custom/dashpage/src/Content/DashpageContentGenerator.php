<?php

/**
 * @file
 */

namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;

use Drupal\views\Views;

/**
 * An example controller.
 $DashpageContentGenerator = new DashpageContentGenerator();
 $DashpageContentGenerator->angularPage();
 */
class DashpageContentGenerator extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function __call($method, $args) {
    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="margin-top-16">';
        $output .= 'DashpageContentGenerator __Call not find this method - ' . $method;
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function angularSnapshot() {
    $output = '';
    $output .= '<div id="pageInfoBase" data-ng-app="pageInfoBase" class="custom-pageinfo pageinfo-subpage-common">';
      $output .= '<div data-ng-controller="PageInfoBaseController" class="row margin-top-16">';

        $output .= '<div class="block-one bg-ffffff padding-bottom-20">';
          $output .= '<div class="row">';

            $output .= '<div class="">';
              $output .= '<div class="float-left">';
                $output .= t('Search') . ' <input data-ng-model="inputFilter.$">';
              $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="margin-top-12">';
              $output .= '<table class="table table-hover">';
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
                      $output .= "{{ tableRowCell }}";
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

  /**
   * render views output
   */
  public function renderViewsContent($views_name = NULL) {
    $output = '';

    if ($views_name) {
      $view_content = views_embed_view($views_name, 'default');

      $output .= '<divclass="dashpage-wrapper margin-top-16">';
        $output .= 'Client List';
        $output .= render($view_content);
      $output .= '</div>';
    }

    return $output;
  }

}
