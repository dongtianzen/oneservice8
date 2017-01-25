<?php

/**
 * @file
 */

namespace Drupal\manageinfo\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 $ManageinfoContentGenerator = new ManageinfoContentGenerator();
 $ManageinfoContentGenerator->angularForm();
 */
class ManageinfoContentGenerator extends ControllerBase {

  /**
   *
   */
  public function angularForm() {
    $output = '';
    $output .= '<div id="pageInfoBase" data-ng-app="pageInfoBase" class="pageinfo-subpage-common">';
      $output .= '<div data-ng-controller="MildderPreFormController" layout="column" ng-cloak>';

        /* Heading */
        $output .= '<div class="row margin-top-40">';
          $output .= '<div class="md-headline">';
            $output .='<span class="padding-top-12">New Referral</span>';
          $output .='</div>';
          $output .= '<div class="col-md-12 height-2 bg-00a9e0 margin-top-20"></div>';
        $output .= '</div>';

        /* Form */
        $output .= '<form novalidate name="preForm" class="preform-wrapper">';
          $output .= '<md-content class="autoScroll padding-24">';

            /* looping */
            $output .= '<div data-ng-repeat="field in formJson.formElementsSection" ng-init="parent=$parent">';
              $output .= '<div ng-switch="field.fieldType">';

                /* Open Text */
                $output .= '<div data-ng-switch-when="textfield">';
                  $output .= '<md-input-container md-block class="width-pt-60">';
                  $output .='<label>{{field.fieldTitle}}</label>';
                    $output .= '<input data-ng-model="field.defaultValue" aria-label="..." data-ng-change="field.updateStatus=\'1\';" data-ng-required="field.fieldRequired">';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* Select */
                $output .= '<div data-ng-switch-when="select">';
                  $output .= '<md-input-container md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'" ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* MultiSelect */
                $output .= '<div data-ng-switch-when="multiSelect">';
                  $output .= '<md-input-container md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select multiple aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'" ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* Select Time and Date */
                $output .= '<div data-ng-switch-when="dateTime">';
                  $output .= '<md-input-container class="width-pt-25">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\';" ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options" data-ng-repeat="options in field.fieldLabel">{{options}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                  $output .= '<span class="margin-left-60">';
                    $output .= '<md-datepicker data-ng-model="referralDate" data-ng-change="convertDate(referralDate)" md-placeholder="Enter Date"></md-datepicker>';
                  $output .= '</span>';
                $output .= '</div>';

                /* Slider */
                $output .= '<div data-ng-switch-when="slider">';
                  $output .= '<md-input-container md-block class="width-pt-60">';
                    $output .= '<span class="slider-label">{{field.fieldTitle}}</span>';
                    $output .= '<md-slider flex="" class="md-primary" md-discrete="" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\';" step="1" min="0" max="10" aria-label="rating" ng-required="field.fieldRequired">';
                    $output .= '</md-slider>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* firstSuperSelect */
                $output .= '<div data-ng-switch-when="firstSuperSelect">';
                  $output .= '<md-input-container md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'; superSelectOptions(field.defaultValue)" ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* firstSubSelect */
                $output .= '<div data-ng-switch-when="firstSubSelect">';
                  $output .= '<md-input-container ng-show="field.fieldShow" md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select multiple aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'" data-ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* Investigations Multi Select */
                $output .= '<div data-ng-switch-when="firstMultiSelectFather">';
                  $output .= '<md-input-container md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select multiple aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'; updateChildfield(field.defaultValue)" data-ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container><br>';
                $output .= '</div>';

                /* CT Select */
                $output .= '<div data-ng-switch-when="firstMultiSelectChild">';
                  $output .= '<md-input-container data-ng-show="showChildField" md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* Select Filter Father */
                $output .= '<div data-ng-switch-when="selectFilterFather">';
                  $output .= '<md-input-container md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'; updateChildOptions(field.defaultValue)" ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container><br>';
                $output .= '</div>';

                 $output .= '<div data-ng-switch-when="selectFilterChild">';
                  $output .= '<md-input-container data-ng-show="field.fieldShow" md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'" ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in filteredLabels">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container><br>';
                $output .= '</div>';

              $output .= '</div>';
            $output .= '</div>';

            /* Action Buttons */
            $output .= '<section>';
              $output .= '<md-button data-ng-disabled="preForm.$invalid" data-ng-click="submit()" class="md-raised pageinfo-btn-saved">Submit</md-button>';
              $output .= '<md-button data-ng-disabled="preForm.$invalid" class="md-raised pageinfo-btn-cancel margin-right-20" data-ng-click="delete()">Delete</md-button>';
            $output .= '</section>';
          $output .= '</md-content>';
        $output .= '</form>';

      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function manageinfoTable() {
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

}
