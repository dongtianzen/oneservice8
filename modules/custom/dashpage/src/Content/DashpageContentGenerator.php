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
  public function angularDemo() {
    $output = '';
    $output .= '<div id="pageInfoBase" data-ng-app="pageInfoBase" class="custom-pageinfo pageinfo-subpage-common">';
      $output .= '<div data-ng-controller="PageInfoBaseController" class="row margin-top-16">';

        $output .= '<div class="block-one bg-ffffff padding-bottom-20">';
          $output .= '<div class="row">';
            $output .= "{{ pageTitle }}";
            $output .= "<br />";
            $output .= "{{ pageSubTitle }}";
            $output .= "<br />";
            $output .= "{{ pageData[0].name }}";
          $output .= '</div>';
        $output .= '</div>';

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

            // $output .= '<div data-ng-repeat="pageDataRow in pageData" ng-init="parent=$parent">';
            //   $output .= "{{ pageDataRow.name }}";
            // $output .= '</div>';

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
  public function clientList() {
    // $view = Views::getView('term_client_collection');

    // $view->setDisplay('default');
    // $view->execute();

// dpm($view->total_rows);
    // $view->getDisplay();

    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="margin-top-16">';
        $output .= 'Client List';
        // $output .= $view->viewsData;
        // $output .= $view->render();
        // $output .= render($view->render());    // method 1
        // $output .= render($view->buildRenderable('default'));// method 2
        $output .= render(views_embed_view('term_client_collection', 'default'));  // method 3
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function companyList() {
    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="margin-top-16">';
        $output .= 'Company List';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function quoteList() {
    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="margin-top-16">';
        $output .= 'Quote List';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function repairList() {
    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="margin-top-16">';
        $output .= 'Repair List';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function userList() {
    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="margin-top-16">';
        $output .= 'User List';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

}
