
/*
 * This controller will take care of parsing the data from json file
 */

var jsonFileUrl = drupalSettings.path.baseUrl + 'manage/term/client/json';
console.log(777);
var pageInfoBaseControllers = angular.module('pageInfoBase', []);

pageInfoBaseControllers.controller('PageInfoBaseController', ['$scope', '$http', '$filter', '$sce',
  function($scope, $http, $filter, $sce) {
    $scope.$sce = $sce;
    $scope.loading = true;
    angular.element(document).ready(function() {
      $http.get(jsonFileUrl).success(function(data) {
        $scope.pageData = data;
        console.log($scope.pageData);
      }).catch(function(err) {
        // Log error somehow.
      }).finally(function() {
        // Hide loading spinner whether our call succeeded or failed.
      });
    });

  }
]);
