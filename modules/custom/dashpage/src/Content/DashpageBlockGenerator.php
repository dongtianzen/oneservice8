<?php

/**
 * @file
 */

namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 $DashpageBlockGenerator = new DashpageBlockGenerator();
 $DashpageBlockGenerator->contentBlockCharts();
 */
class DashpageBlockGenerator extends ControllerBase {

  /*
   *
   */
  function contentRenderHeader() {
    $output = '';
    $output .= '<div class="panel-header block-header">';
      $output .= '<span>{{block.top.value}}</span>';
      // $output .= '<md-menu>';
      //   $output .= '<span id="save-charts-{{block.blockId}}" ng-click="openMenu($mdOpenMenu, $event)" class="fa fa-angle-down float-right font-size-14 padding-12 cursor-pointer"></span>';
      //   $output .= '<md-menu-content width="3">';
      //     $output .= '<md-button ng-click="saveAsPng(\'charts\', block.blockId)"> ';
      //       $output .= 'Save PNG';
      //     $output .= '</md-button>';
      //   $output .= '</md-menu-content>';
      // $output .= '</md-menu>';
    $output .= '</div>';

    return $output;
  }

  /*
   * Content Render Charts
   */
  function contentRenderCharts() {
    // Render  Charts
    $output = '';
    $output .= '<div class="content-render-chart-wrapper">';
      $output .= '<div ng-bind-html="$sce.trustAsHtml(block.middle.middleTop)">{{block.middle.middleTop}}</div>';

      $output .= '<div class="{{block.middle.middleMiddle.middleMiddleLeftClass}}">';
        $output .= '<span ng-bind-html="$sce.trustAsHtml(block.middle.middleMiddle.middleMiddleLeft)">{{block.middle.middleMiddle.middleMiddleLeft}}</span>';
      $output .= '</div>';

      $output .= '<div class="{{block.middle.middleMiddle.middleMiddleMiddleClass}}">';
        $output .= '<canvas width="600" height="403" flexxiachartjs options="{{block.middle.middleMiddle.middleMiddleMiddle.chartOptions}}" type="{{block.middle.middleMiddle.middleMiddleMiddle.chartType}}" id="{{block.middle.middleMiddle.middleMiddleMiddle.chartId}}" data="{{block.middle.middleMiddle.middleMiddleMiddle.chartData}}"></canvas>';
      $output .= '</div>';

      $output .= '<div class="{{block.middle.middleMiddle.middleMiddleRightClass}}">';
        $output .= '<span ng-bind-html="$sce.trustAsHtml(block.middle.middleMiddle.middleMiddleRight)">{{block.middle.middleMiddle.middleMiddleRight}}</span>';
      $output .= '</div>';

      $output .= '<div class="col-sm-12" ng-bind-html="$sce.trustAsHtml(block.middle.middleBottom)">{{block.middle.middleBottom}}</div>';
    $output .= '</div>';

    return $output;
  }

  /*
   * Content Elements comments
   */
  function contentRenderComments() {
    $output = '';
    $output .= '<div class="panel-body bg-ffffff">';
      $output .= '<md-content class="padding-bottom-12">';
        $output .= '<span ng-bind-html="$sce.trustAsHtml(block.middle.value)">{{block.middle.value}}</span>';
      $output .= '</md-content>';
    $output .= '</div>';

    return $output;
  }

  /*
   * Content Elements comments
   */
  function contentRenderGoogleMap() {
    $output = '';
    $output .= '<div class="panel-body bg-ffffff">';
      $output .= '<div id="map" class="google-map-wrapper">map</div>';
    $output .= '</div>';

    return $output;
  }

  /*
   * Content Render Table
   */
  function contentRenderTable() {
    $output = '';
    $output .= '<div class="content-render-table-wrapper">';

      // Middle Top
      $output .= '<div ng-bind-html="$sce.trustAsHtml(block.middle.middleTop)">{{block.middle.middleTop}}</div>';

      // Middle Middle Left
      $output .= '<div class={{block.middle.middleMiddle.middleMiddleLeftClass}}>';
        $output .= '<span ng-bind-html="$sce.trustAsHtml(block.middle.middleMiddle.middleMiddleLeft)">{{block.middle.middleMiddle.middleMiddleLeft}}</span>';
      $output .= '</div>';

      // Middle Middle content
      $output .= '<div class={{block.middle.middleMiddle.middleMiddleMiddleClass}}>';
        $output .= '<div data-ng-controller="AngularDataTables" class="row margin-0 margin-top-16">';
          $output .= '<table datatable="ng" dt-options="dtOptionsCommonTables" class="table table-striped">';
            $output .= '<thead>';
            $output .= '<tr>';
              $output .= '<th data-ng-repeat="tablehead in block.middle.middleMiddle.middleMiddleMiddle.value.thead[0]">';
                $output .= '{{tablehead}}';
              $output .= '</th>';
            $output .= '</tr>';
            $output .= '</thead>';
              $output .= '<tbody>';
                $output .= '<tr data-ng-repeat="tableRow in block.middle.middleMiddle.middleMiddleMiddle.value.tbody">';
                  $output .= '<td data-ng-repeat="tableCell in tableRow track by $index">';
                    $output .= '<span ng-bind-html="$sce.trustAsHtml(tableCell)">{{tableCell}}</span>';
                  $output .= '</td>';
                $output .= '</tr>';
              $output .= '</tbody>';
          $output .= '</table>';
        $output .= '</div>';
      $output .= '</div>';

      // Middle Middle Right
      $output .= '<div class={{block.middle.middleMiddle.middleMiddleRightClass}}>';
        $output .= '<span ng-bind-html="$sce.trustAsHtml(block.middle.middleMiddle.middleMiddleRight)">{{block.middle.middleMiddle.middleMiddleRight}}</span>';
      $output .= '</div>';

      // Middle Bottom
      $output .= '<div class="col-sm-12" ng-bind-html="$sce.trustAsHtml(block.middle.middleBottom)">{{block.middle.middleBottom}}</div>';
    $output .= '</div>';

    return $output;
  }

  /*
   * Content Render MultiContainer
   */
  function contentRenderMultiContainer() {
    $output = '';
    $output .= '<div class="content-render-multicontainer-wrapper">';
      $output .= '<div ng-bind-html="$sce.trustAsHtml(block.middle.middleTop)">{{block.middle.middleTop}}</div>';

      // Middle Left
      $output .= '<div class="{{block.middle.middleMiddle.middleMiddleLeftClass}}">';
        $output .= '<span ng-bind-html="$sce.trustAsHtml(block.middle.middleMiddle.middleMiddleLeft)">{{block.middle.middleMiddle.middleMiddleLeft}}</span>';
      $output .= '</div>';

      // Rendering  Chart (chartnew.js)
      $output .= '<div class="{{block.middle.middleMiddle.middleMiddleMiddleClass}}">';
        $output .= '<div data-ng-repeat="chart in block.middle.middleMiddle.middleMiddleMiddle">';
          $output .= '<div id="chartContainer-{{$index}}" class="{{chart.chartClass}}">';
            $output .= '<canvas width="600" height="402" flexxiachartjs options="{{chart.chartOptions}}" type="{{chart.chartType}}" id="{{chart.chartId}}" data="{{chart.chartData}}">
            </canvas>';
            $output .= '<div class="row margin-top-n-10 margin-bottom-12 padding-left-24 font-size-13 text-align-left">';
              $output .= '<span>{{chart.chartTitle}}</span>';
            $output .= '</div>';
          $output .= '</div>';
        $output .= '</div>';
      $output .= '</div>';

      // Middle Right
      $output .= '<div class={{block.middle.middleMiddle.middleMiddleRightClass}}>';
        $output .= '<span ng-bind-html="$sce.trustAsHtml(block.middle.middleMiddle.middleMiddleRight)">{{block.middle.middleMiddle.middleMiddleRight}}</span>';
      $output .= '</div>';

      // Middle Bottom
      $output .= '<div class="col-sm-12" ng-bind-html="$sce.trustAsHtml(block.middle.middleBottom)">{{block.middle.middleBottom}}</div>';
    $output .= '</div>';
    return $output;
  }

  /*
   * Content Render Bottom
   */
  function contentRenderBottom() {
    // bottom
    $output = '';
    $output .= '<div class="col-md-12" ng-bind-html="$sce.trustAsHtml(block.bottom.value)">{{block.bottom.value}}';
    $output .= '</div>';

    return $output;
  }
  /*----------------------------------------------------------------*/

  /*
   * Top fixed widgets
   */
  function topWidgetsFixed($nid = NULL) {
    $output = '';
    $output .= '<div data-ng-repeat="widget in pageData.fixedSection">';
      $output .= '<div data-ng-switch="widget.type">';
        /*
         * Widget type "widgetOne"
         */
        $output .= '<div data-ng-switch-when="widgetOne">';
          $output .= '<div class="{{widget.class}} margin-top-6">';
            $output .=  '<md-content>';
              $output .= '<div id="block-topWidgets-{{$index}}" class="dashpage-square-number-wrapper border-radius-3 {{widget.value.header.class}}">';
                $output .= '<md-tooltip md-direction="bottom" class="tt-multiline" ng-if="widget.value.header.widgetTooltip">';
                  $output .= '<span class="font-size-14">{{widget.value.header.widgetTooltip.title}}</span>';
                  $output .= '<span class="font-size-12" ng-bind-html="$sce.trustAsHtml(widget.value.header.widgetTooltip.content)">';
                    $output .= '{{widget.value.header.widgetTooltip.content}}';
                  $output .= '</span>';
                $output .= '</md-tooltip>';
                $output .= '<div class="padding-12">';
                  $output .= '<div class="padding-top-6 font-size-16">{{widget.value.header.valueOne.value}}';
                    $output .= '<md-menu>';
                      $output .= '<span id="save-topWidgets-{{$index}}" ng-click="openMenu($mdOpenMenu, $event)" class="fa fa-angle-down float-right padding-12 padding-top-0 cursor-pointer"></span>';
                      $output .= '<md-menu-content width="3">';
                        $output .= '<md-button ng-click="saveAsPng(\'topWidgets\',$index)"> ';
                          $output .= 'Save PNG';
                        $output .= '</md-button>';
                      $output .= '</md-menu-content>';
                    $output .= '</md-menu>';
                  $output .= '</div>';
                  $output .= '<div class="line-height-1-5 margin-top-12 font-size-12" ng-bind-html="$sce.trustAsHtml(widget.value.header.value.value)">{{widget.value.header.value.value}}</div>';
                $output .= '</div>';
              $output .= '</div>';
            $output .= '</md-content>';
          $output .= '</div>';
        $output .= '</div>';

      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /*
   * Content Elements contains multiple tabs
   */
  function contentBlockMultiTabs() {
    $output = '';
    $output .= '<md-tabs md-selected="selectedIndex" md-dynamic-height="" md-border-bottom="">';
      $output .= '<md-tab ng-repeat="block in block.middle.value" label="{{block.title}}">';
        $output .= '<div data-ng-switch="block.type">';
          $output .= '<div data-ng-switch-when="chart" class="{{block.class}}">';
            $output .= $this->contentRenderCharts();
          $output .= '</div>';
          $output .= '<div data-ng-switch-when="table" class="{{block.class}}">';
            $output .= $this->contentRenderTable();
          $output .= '</div>';
          $output .= '<div data-ng-switch-when="multiContainer" class="{{block.class}}">';
            $output .= $this->contentRenderMultiContainer();
          $output .= '</div>';
        $output .= '</div>';
      $output .= '</md-tab>';
    $output .= '</md-tabs>';

    return $output;
  }

  /*
   * Content Master contain multiple elements
   */
  function contentBlockMaster() {
    $output = '';
    $output .= '<div id="block-charts-{{block.blockId}}" class="panel block">';
      $output .= '<div ng-if="block.top.enable">';
        $output .= '<md-content>';
          $output .= $this->contentRenderHeader();
        $output .= '</md-content>';
      $output .= '</div>';

      $output .= '<div class="panel-body bg-ffffff">';
        $output .= '<div ng-if="block.middle.enable">';
          $output .= '<md-content class="{{block.blockClasses}}">';
            $output .= '<div data-ng-switch="block.type">';
              $output .= '<div data-ng-switch-when="multiContainer">';
                $output .= $this->contentRenderMultiContainer();
              $output .= '</div>';
              $output .= '<div data-ng-switch-when="chart">';
                $output .= $this->contentRenderCharts();
              $output .= '</div>';
              $output .= '<div data-ng-switch-when="comments">';
                $output .= $this->contentRenderComments();
              $output .= '</div>';
              $output .= '<div data-ng-switch-when="commonTable">';
                $output .= $this->contentRenderTable();
              $output .= '</div>';
              $output .= '<div data-ng-switch-when="googleMap">';
                $output .= $this->contentRenderGoogleMap();
              $output .= '</div>';

              $output .= '<div data-ng-switch-when="multiTabs">';
                $output .= $this->contentBlockMultiTabs();
              $output .= '</div>';

            $output .= '</div>';
          $output .= '</md-content>';
        $output .= '</div>';
        $output .= '<div ng-if="block.bottom.enable">';
          $output .= '<md-content>';
            $output .= $this->contentRenderBottom();
          $output .= '</md-content>';
        $output .= '</div>';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

}
