/**
 *@file
 */

var pageInfoBaseControllers = angular.module('pageInfoBase', ['ngResource']);
pageInfoBaseControllers.controller('QuotePrintController', ['$scope', '$http', '$element', '$filter', '$sce',
  function($scope, $http, $element, $q, $filter) {

    jQuery.get(drupalSettings.path.baseUrl + 'rest/session/token').done(function (data) {
      $scope.csrfToken = data;
    });

    $scope.authorizeSubmit = function(status) {
      var pathArg = drupalSettings.path.currentPath.split('/');
      var postUrl = drupalSettings.path.baseUrl + 'node/' + pathArg[3];
      var redirectUrl = drupalSettings.path.baseUrl + drupalSettings.path.currentPath;

      var postNodeJson = {
        "type": [{ "target_id": "quote" }],
        "field_quote_authorizestamp": [{ "value": status }],     // or value
      };

      $http({
        method  : 'PATCH',   // GET, POST, PATCH, DELETE
        url     : postUrl,
        data    : postNodeJson,
        headers : {'Content-Type': 'application/json', 'X-CSRF-Token': $scope.csrfToken},
      }).then(function(response) {
        console.log('Success');

        window.location.replace(redirectUrl);
      },function (error) {

      });
    }

  }
]);


