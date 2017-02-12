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
                    $output .= '<md-select aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'" data-ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* MultiSelect */
                $output .= '<div data-ng-switch-when="multiSelect">';
                  $output .= '<md-input-container md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select multiple aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'" ="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* Select Time and Date */
                $output .= '<div data-ng-switch-when="dateTime">';
                  $output .= '<md-input-container class="width-pt-25">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\';" ="field.fieldRequired">';
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
                    $output .= '<md-slider flex="" class="md-primary" md-discrete="" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\';" step="1" min="0" max="10" aria-label="rating" ="field.fieldRequired">';
                    $output .= '</md-slider>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* singleSelectFather */
                $output .= '<div data-ng-switch-when="singleSelectFather">';
                  $output .= '<md-input-container md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'; superSelectOptions(field.defaultValue)" data-ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* singleFatherMultipleChild */
                $output .= '<div data-ng-switch-when="singleSelectFatherMultipleChild">';
                  $output .= '<md-input-container ng-show="field.fieldShow" md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select multiple aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'" data-ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* firstMultiSelectFather */
                $output .= '<div data-ng-switch-when="firstMultiSelectFather">';
                  $output .= '<md-input-container md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select multiple aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'; updateChildfield(field.defaultValue)" data-ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                /* firstMultiSelectChild */
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
                    $output .= '<md-select aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'; updateChildOptions(field.defaultValue)" data-ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in field.fieldLabel">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
                $output .= '</div>';

                 /* Select Filter Child */
                 $output .= '<div data-ng-switch-when="selectFilterChild">';
                  $output .= '<md-input-container data-ng-show="field.fieldShow" md-block class="width-pt-60">';
                    $output .= '<label>{{field.fieldTitle}}</label>';
                    $output .= '<md-select aria-label="select" data-ng-model="field.defaultValue" data-ng-change="field.updateStatus=\'1\'" data-ng-required="field.fieldRequired">';
                      $output .= '<md-option data-ng-value="options.termTid" data-ng-repeat="options in filteredLabels">{{options.termName}}</md-option>';
                    $output .= '</md-select>';
                  $output .= '</md-input-container>';
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
  public function settingIndex() {
    $setting_array = array(
      array(
        'url' => '/superinfo/table/client',
        'name' => 'Client',
      ),
      array(
        'url' => '/superinfo/table/client_type',
        'name' => 'Client Type',
      ),
      array(
        'url' => '/superinfo/table/company',
        'name' => 'Company',
      ),
      array(
        'url' => '/superinfo/table/device_type',
        'name' => 'Device Type',
      ),
      array(
        'url' => '/superinfo/table/notification',
        'name' => 'Notification',
      ),
      array(
        'url' => '/superinfo/table/province',
        'name' => 'Province',
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
