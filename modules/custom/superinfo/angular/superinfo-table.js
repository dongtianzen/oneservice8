/*
 * This controller will take care of parsing the data from json file
 */

var pageInfoBaseControllers = angular.module('pageInfoBase', []);

pageInfoBaseControllers.controller('PageInfoBaseController', ['$scope', '$http', '$filter', '$sce',
  function($scope, $http, $filter, $sce) {

    $scope.$sce = $sce;

    var jsonFileUrl = drupalSettings.superinfo.superinfoTable.jsonFileUrl;

    angular.element(document).ready(function() {

      $http({
        method: 'GET',
        url: jsonFileUrl
      }).then(function(response) {
        $scope.pageData = response.data;
      },function (error) {
        // if error occurs
      });

    });

  }
]);
