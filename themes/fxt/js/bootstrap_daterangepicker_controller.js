jQuery(document).ready(function($) {
  var pathArg = drupalSettings.path.currentPath.split('/');

  /**
   * Date Range Picker
   * Pre-defined Ranges & Callback
   *
   */
  jQuery(function() {

    // set dropdown hightlight item, the menu will highlight same one
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {

      // start.valueOf() is Unix TimeStamp
      var startDate = parseInt((start.valueOf()) / 1000);
      var endDate = parseInt((end.valueOf()) / 1000);

      // add new date range parameter
      var redirectUrl = drupalSettings.path.baseUrl + pathArg[0] + '/' + pathArg[1] + '/' + pathArg[2] + '/' + pathArg[3] + '/' + startDate + '/' + endDate;

      // redirect page
      window.location.replace(redirectUrl);
    }

    jQuery('#reportrange-header').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
          '2014 Year': [moment("20140101"), moment("20141231")],
          '2015 Year': [moment("20150101"), moment("20151231")],
          '2016 Year': [moment("20160101"), moment("20161231")],
          'YTD': [moment().startOf('year'), moment()],
          '2017 Q1': [moment("20170101"), moment("20170331")],
          '2017 Q2': [moment("20170401"), moment("20170630")],
        }
    }, cb);

  });

});
