jQuery(document).ready(function($) {
  // var basePathUrl = Drupal.settings.basePath;

  // var lastMeetingDate = Drupal.settings.meetingtype.lastMeetingDate;
  var lastMeetingDate = moment();
  if (lastMeetingDate < moment()) {
    lastMeetingDate = moment();
  };

  /**
   * Date Range Picker
   * Pre-defined Ranges & Callback
   *
   */
  $('#block-fxt-main-menu').daterangepicker(
    {
      ranges: {
        // 'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
        // 'Specify Range': [moment("10-06-2014", "MM-DD-YYYY"), moment("10-06-2015", "MM-DD-YYYY")],
        'Last 30 Days': [moment().subtract('days', 29), moment()],
        'Last 60 Days': [moment().subtract('days', 59), moment()],
        'Last 90 Days': [moment().subtract('days', 89), moment()],
        'YTD': [moment().startOf('year'), moment()],
        'All Meetings': [moment("09-01-2014", "MM-DD-YYYY"), moment(lastMeetingDate)],
      },

      startDate: moment().subtract('days', 30),
      endDate: moment()
    },
    // action after click "apply" button or above quick "ranges" link
    function(start, end) {
      $('#reportrange-header span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

      // start.valueOf() is Unix TimeStamp
      var startDate = parseInt((start.valueOf()) / 1000);
      var endDate = parseInt((end.valueOf()) / 1000);

      // check path
      var path = $(location).attr('href');
      var pathArray = path.split("/");

      // get URL only path arg() without unix timestamp
      var pathFilter = '';
      $.each( path.split("/"), function( key, value ) {
        if ( (value.length > 9) && ($.isNumeric(value)) ) {
          // Unix TimeStamp length is 10, ignore the URL Unix TimeStamp
        }
        else {
          if (key == 0) {
            pathFilter += value;
          }
          else {
            pathFilter += '/' + value;
          }
        }
      });

      // add new date range parameter
      var pathDate = pathFilter + '/' + startDate + '/' + endDate;

      // // Set Usesr Date Range on User Data
      // var url = basePathUrl + 'jsonservice/user/set-date-range/' + startDate + '/' + endDate;
      // $.ajax({
      //   type: "POST",
      //   url: url,
      // });

      // var xmlhttp = new XMLHttpRequest();
      // xmlhttp.open("GET", url, false);

      // redirect page
      window.location.replace(pathDate);
    }
  );
});
