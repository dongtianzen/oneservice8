/*
 * This controller will take care of parsing the data from json file
 */

// var jsonFileUrl = drupalSettings.path.baseUrl + 'modules/custom/dashpage/angular/mildderjson.json';
var jsonFileUrl = drupalSettings.path.baseUrl + 'manage/term/client/json';

var pageInfoBaseControllers = angular.module('pageInfoBase', ['flexxiaChartsnewjs', 'ngMaterial', 'datatables', 'ngResource', 'datatables.buttons']);

pageInfoBaseControllers.controller('PageInfoBaseController', ['$scope', '$http', '$mdDialog', '$mdMedia', '$filter', '$sce',
  function($scope, $http, $mdDialog, $mdMedia, $filter, $sce) {
    $scope.$sce = $sce;

    angular.element(document).ready(function() {
      $http.get(jsonFileUrl).success(function(data) {

        // when manageinfo call table page, $scope.pageData use drupalSettings variable
        if ((drupalSettings.path.currentPath.indexOf("manageinfo/") > -1) && (typeof drupalSettings.manageinfo.manageinfoTable.jsonContentData !== 'undefined')) {
          $scope.pageData = drupalSettings.manageinfo.manageinfoTable.jsonContentData;
        }
        else if (typeof drupalSettings.dashpage.dashpageContent.jsonContentData !== 'undefined') {
          $scope.pageData = drupalSettings.dashpage.dashpageContent.jsonContentData;
        }
        else {
          $scope.pageData = data;
        }
      }).catch(function(err) {
        // Log error somehow.
      }).finally(function() {

      });
    });

  }
]);

/* Datatables Controller */
pageInfoBaseControllers.controller('AngularDataTables', DataTablesCtrl);
function DataTablesCtrl($http, $scope, $resource, DTOptionsBuilder, DTColumnDefBuilder, DTDefaultOptions) {
  angular.forEach($scope.pageData.contentSection, function(value) {
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
jQuery(document).ready(function() {
  if(document.getElementById('navInfoBase') !== null) {
    angular.bootstrap(document.getElementById("pageInfoBase"), ['pageInfoBase']);
  }
});
