

jQuery(document).ready(function($) {
console.log(333);
  var pathArg = drupalSettings.path.currentPath.split('/');

  // window.location.replace(redirectUrl);

   */
  $scope.quoteAuthorizeButton = function() {
    var postUrl = drupalSettings.path.baseUrl + $scope.formJson.formInfo.postUrl;
    var redirectUrl = drupalSettings.path.baseUrl + $scope.formJson.formInfo.redirectUrl;

    // standard json example
    // var postTermJson2 = {
    //   "vid": [{ "target_id": "province" }],
    //   "name": [{ "value": "aaa new province" }],
    //   "field_province_region": [{ "target_id": 23 }, { "target_id": 63 }],    // multiple
    //   "field_city_name": [{ "value": "windsor" }],     // or value
    // };

    $http({
      method  : 'PATCH',   // GET, POST, PATCH, DELETE
      url     : postUrl,
      data    : postTermJsonObject,
      headers : {'Content-Type': 'application/json', 'X-CSRF-Token': $scope.csrfToken},
    }).then(function(response) {
      console.log('Success');
      console.log(response);

      window.location.replace(redirectUrl);
    },function (error) {
      console.log(error);
    });
  }

});

