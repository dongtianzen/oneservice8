var navInfoUrl = drupalSettings.path.baseUrl + 'modules/custom/navinfo/angular/navbar.json';

var navInfoBaseControllers = angular.module('navInfoBase', ['ngMaterial']);
navInfoBaseControllers.controller('NavInfoBaseController', ['$timeout', '$scope', '$http', function($timeout, $scope, $http, $sce) {

  angular.element(document).ready(function() {
    $http.get(navInfoUrl).success(function(data) {
      $scope.navInfoJson = data;
    }).catch(function(err) {
      // Log error somehow.
    }).finally(function() {
      console.log(basePathUrl);
      $scope.checkBrowser();
      // Hide loading spinner whether our call succeeded or failed.
      $scope.loading = false;
    });
  });

  $scope.submitValue = function(selectedObject) {
    var postUrl = $scope.navInfoJson.navInfoUrls.postUrl + '/' + selectedObject.termTid;
    var redirectUrl = $scope.navInfoJson.navInfoUrls.redirectUrl;

    // $http.post(postUrl).then(function(response) {
    //   // this callback will be called asynchronously when the response is available
    //   $scope.status = response.status;
    //   $scope.data = response.data;

    //   window.location.replace(basePathUrl + 'redirectUrl');
    // }, function(response) {
    //   // called asynchronously if an error occurs or server returns response with an error status.
    //   $scope.data = response.data || "Request failed";
    //   $scope.status = response.status;
    //   console.log('response failed');
    // });
  }
}]);


