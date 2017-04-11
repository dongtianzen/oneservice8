/*
 * This controller will take care of parsing the data from json file
 */

// var jsonFileUrl = drupalSettings.path.baseUrl + 'modules/custom/manageinfo/angular/angular-form.json';
var jsonFileUrl = drupalSettings.path.baseUrl + 'manageinfo/angular/json/66';

var formType = 'create';
// var formType = 'edit';

var pageInfoBaseControllers = angular.module('pageInfoBase', ['ngResource', 'ngMaterial']);
pageInfoBaseControllers.controller('MildderPreFormController', ['$scope', '$http', '$timeout', '$q', '$log', '$filter','$mdDialog', '$element',
  function($scope, $http, $timeout, $q, $log, $filter, $mdDialog, $element) {

    angular.element(document).ready(function() {

      $http({
        method: 'GET',
        url: jsonFileUrl
      }).then(function(response) {
        $scope.formJson = response.data;
      },function(error) {
        // if error occurs
      });

    });
    // singleFatherMultipleChild options
    $scope.superSelectOptions = function(answerTid) {
      console.log(answerTid);
      $scope.clearSubModels();
      angular.forEach($scope.formJson.formElementsSection, function(field) {
        if(field.fieldTid == answerTid) {
          field.fieldShow = true;
        }
      });
    }

    //clearing subModels on select
    $scope.clearSubModels = function() {
      angular.forEach($scope.formJson.formElementsSection, function(field) {
        if(field.filter == true) {
          field.defaultValue = '';
          field.fieldShow = false;
          field.updateStatus = 0;
        }
      });
    }

    // show Ct chest question
    $scope.updateChildfield = function(answerTid) {
      if(answerTid.indexOf(1125) >= 0) {
        $scope.showChildField = true;
      }
      else {
        $scope.showChildField = false;
      }
    }

    $scope.convertDate  = function(referralDate) {
      angular.forEach($scope.formJson.formElementsSection, function(field) {
        if(field.fieldType == 'datetime') {
          var time = field.defaultValue;
          console.log(time);
          var formatDate = $filter('date')(referralDate, 'EEEE, MMMM d, y');
          var timeStamp = formatDate + ' ' + time;
          timeStamp = Date.parse(timeStamp) / 1000;
          field.defaultValue = timeStamp;
          console.log(field.defaultValue);
        }
      });
    }

    $scope.updateChildOptions = function(answerTid) {
      $scope.filteredLabels = [];
      angular.forEach($scope.formJson.formElementsSection, function(field) {
        if(field.fieldType == 'selectFilterChild') {
          field.fieldShow = true;
          angular.forEach(field.fieldLabel, function(value) {
            if(value.parentTid == answerTid) {
              $scope.filteredLabels.push(value);
            }
          });
        }
      });
    }

    /*
     * post form function
     */
    $scope.submit  = function() {
      $scope.submitAnswers = [];
      if(formType == 'create') {
        angular.forEach($scope.formJson.formElementsSection, function(field) {
          if(field.defaultValue != null) {
            $scope.submitAnswers[field.fieldTitle] = field.defaultValue;
          }
        });
      }
      else if (formType == 'edit') {
        angular.forEach($scope.formJson.formElementsSection, function(field) {
          if(field.updateStatus == 1) {
            $scope.submitAnswers[field.fieldTitle] = field.defaultValue;
          }
        });
      }
      console.log($scope.submitAnswers);

      var createNodeJson = JSON.stringify($scope.submitAnswers);
      console.log(createNodeJson);

      var postUrl = $scope.formJson.formInfo.postUrl;
      var redirectUrl = $scope.formJson.formInfo.redirectUrl;
      // $http.post(postUrl).then(function(response) {

     //    // this callback will be called asynchronously when the response is available
     //    $scope.status = response.status;
     //    $scope.data = response.data;

     //    window.location.replace(redirectUrl);
     //  }, function(response) {
     //    // called asynchronously if an error occurs or server returns response with an error status.
     //    $scope.data = response.data || "Request failed";
     //    $scope.status = response.status;
     //    console.log('response failed');
     //  });
    }

    /*
     * delete form function
     */
    $scope.delete = function() {

    }
  }
]);

// code to load 2 apps
jQuery(document).ready(function() {
  if(document.getElementById('navInfoBase') !== null) {
    angular.bootstrap(document.getElementById("pageInfoBase"), ['pageInfoBase']);
  }
});
