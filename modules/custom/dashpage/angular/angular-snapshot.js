
/*
 * This controller will take care of parsing the data from json file
 */

var jsonFileUrl = drupalSettings.path.baseUrl + 'manage/term/client/json';
var pageInfoBaseControllers = angular.module('pageInfoBase', []);

pageInfoBaseControllers.controller('PageInfoBaseController', ['$scope', '$http', '$filter', '$sce',
  function($scope, $http, $filter, $sce) {

    $scope.$sce = $sce;

    angular.element(document).ready(function() {
      $http.get(jsonFileUrl).success(function(data) {
        $scope.pageData = data;

        if ((drupalSettings.path.currentPath.indexOf("manageinfo/") > -1) && (typeof drupalSettings.manageinfo.manageinfoTable.jsonContentData !== 'undefined')) {
          $scope.pageData = drupalSettings.manageinfo.manageinfoTable.jsonContentData;
        }
        else {
          $scope.pageData = data;
        }
      }).catch(function(err) {
        // Log error somehow.
      }).finally(function() {
        // Hide loading spinner whether our call succeeded or failed.
      });
    });

  }
]);
