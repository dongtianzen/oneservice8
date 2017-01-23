
/*
 * This controller will take care of parsing the data from json file
 */

var jsonFileUrl = drupalSettings.path.baseUrl + 'manage/term/client/json';
var pageInfoBaseControllers = angular.module('pageInfoBase', []);

pageInfoBaseControllers.controller('PageInfoBaseController', ['$scope', '$http', '$filter', '$sce',
  function($scope, $http, $filter, $sce) {

    $scope.$sce = $sce;
    $scope.pageTitle = 'This is angularjs page';
    $scope.pageSubTitle = 'This is angularjs Demo page';

    angular.element(document).ready(function() {
      $http.get(jsonFileUrl).success(function(data) {
        $scope.pageData = data;
      }).catch(function(err) {
        // Log error somehow.
      }).finally(function() {
        // Hide loading spinner whether our call succeeded or failed.
      });
    });

  }
]);
