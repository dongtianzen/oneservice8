
/*
 * This controller will take care of parsing the data from json file
 */

var jsonFileUrl = drupalSettings.path.baseUrl + 'manage/term/client/json';

var pageInfoBaseControllers = angular.module('pageInfoBase', ['flexxiaChartsnewjs', 'ngMaterial', 'datatables', 'ngResource', 'datatables.buttons']);

pageInfoBaseControllers.controller('PageInfoBaseController', ['$scope', '$http', '$mdDialog', '$mdMedia', '$filter', '$sce',
  function($scope, $http, $mdDialog, $mdMedia, $filter, $sce) {
    $scope.$sce = $sce;
    $scope.loading = true;
    angular.element(document).ready(function() {
      $http.get(jsonFileUrl).success(function(data) {
        $scope.landingPageData = data;
      }).catch(function(err) {
        // Log error somehow.
      }).finally(function() {
        $scope.checkBrowser();
        // Hide loading spinner whether our call succeeded or failed.
        $scope.loading = false;
      });
    });

    $scope.checkBrowser = function() {
      var isChrome = !!window.chrome && !!window.chrome.webstore;
      var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
      if (!isChrome) {
        if (!isSafari) {
          $mdDialog.show({
            clickOutsideToClose: true,
            parent: angular.element(document.body),
            scope: $scope,
            preserveScope: true,
            template: '<md-dialog flex="25">' +
            '<md-dialog-content class="onetime-browser-alert padding-24">' +
            '  <h2>Before We Continue</h2>The Dashbpard perform best using updated safari or Chrome Browser' +
            '</md-dialog-content>' +
            '<div class="md-actions">' +
            '  <md-button ng-click="closeDialog()" class="md-primary pageinfo-btn-saved">' +
            '    Got it' +
            '  </md-button>' +
            '</div>' +
            '</md-dialog>',
            controller: function DialogController($scope, $mdDialog) {
              $scope.closeDialog = function() {
                $mdDialog.hide();
              }
            }
          });
        }
      }
    }
  }
]);

/* Datatables Controller */
pageInfoBaseControllers.controller('AngularDataTables', DataTablesCtrl);
function DataTablesCtrl($http, $scope, $resource, DTOptionsBuilder, DTColumnDefBuilder, DTDefaultOptions) {
  angular.forEach($scope.landingPageData.contentSection, function(value) {
    if(value.type == "commonTable") {
      $scope.tableSettings = value.middle.middleMiddle.middleMiddleMiddle.tableSettings;
    }
  });
  $scope.dtOptionsCommonTables = {
    paginationType: $scope.tableSettings.paginationType,
    bInfo: false,
    bPaginate: $scope.tableSettings.pagination,
    bFilter: $scope.tableSettings.searchFilter,
    language: {
      "searchPlaceholder": $scope.tableSettings.searchPlaceholder,
      "sSearch": "",
      "oPaginate": {
        "sFirst": "",
        "sLast": "",
        "sNext": "<span class='fa fa-caret-right color-00a9e0'></span>",
        "sPrevious": "<span class='fa fa-caret-left color-00a9e0'></span>",
      },
      "sLengthMenu": '<select>' + '<option value="10">SHOW 10</option>' + '<option value="20">SHOW 20</option>' + '<option value="30">SHOW 30</option>' + '<option value="40">SHOW 40</option>' + '<option value="50">SHOW 50</option>' + '<option value="-1">SHOW All</option>' + '</select> '
    },
  };
}

// code to load 2 apps
jQuery(document).ready(function(){
  // angular.bootstrap(document.getElementById("pageInfoBase"), ['pageInfoBase']);
});
