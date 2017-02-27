<?php

/**
 * @file
 * Contains \Drupal\dashpage\Controller\DashpageJsonGenerator.
 */

namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 *
 $JsonDashpageBase = new JsonDashpageBase();
 $JsonDashpageBase->getCommonTable();
 */
class JsonDashpageBase {
  private $post_url = NULL;

  public function getPostUrl() {
    return $this->post_url;
  }

  public function setPostUrl($value = NULL) {
    $this->post_url = $value;
  }

  /** - - - - - field- - - - - - - - - - - - - - - */
  /**
   *
   */
  public function getTileStyleOne($option = array(), $value = NULL, $value_one = NULL) {
    $output = array(
      'blockId' => 1,
      'class' => "col-md-3 col-xs-6",
      'type'  => "widgetOne",
      'value' => array(
        'header' => array(
          'class' => "color-fff",
          'value' => array(
            'class' => "font-size-14",
            'value' => $value,
          ),
          'valueOne' => array(
            'class' => "font-size-12",
            'value' => $value_one,
          ),
        ),
      ),
    );

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   */
  public function getBlockOne($option = array(), $middle_middle_value = array()) {
    $output = array(
      'blockId' => uniqid(),
      'class' => "col-md-12",
      'blockClasses' => '',
      'type' => "chart",          // chart or multiContiner, commonTable, googleMap
      'top'  =>  array(
        'enable' => true,
        'value' => NULL,          // block top title value
      ),
      'middle' =>  array(
        'enable' => true,
        'middleTop' => NULL,      // block middleTop HTML value, "<div>Multi-Chart-Middle-Top</div>"
        'middleMiddle' =>  array(
          'middleMiddleLeftClass' => "",
          'middleMiddleLeft' => "",
          'middleMiddleMiddleClass' => "",
          'middleMiddleMiddle' => $middle_middle_value,
          'middleMiddleRightClass' => "",
          'middleMiddleRight' => ""
        ),
        'middleBottom' => NULL,   // block middleBottom HTML value, "<div>Multi-Chart-Middle-Bottom</div>"
      ),
      'bottom' => array(
        'enable' => true,
        'value' => NULL,          // block Bottom HTML value, "<div>Multi-Chart-Bottom</div>"
      )
    );

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   */
  public function getBlockTabContainer($option = array(), $middle_middle = NULL) {
    $output = array(
      'blockId' => 67,
      'class' => "col-md-12",
      'blockClasses' => 'col-md-6',    // write comments
      'title' => "Tab 1",
      'type' => "chart",
      'top' =>  array(
        'enable' => true,
        'value' => NULL
      ),
      'middle' =>  array(
        'enable' => true,
        'middleTop' => NULL,
        'middleMiddle' =>  array(
          'middleMiddleLeftClass' => "",
          'middleMiddleLeft' => "",
          'middleMiddleMiddleClass' => "col-sm-10",
          'middleMiddleMiddle' => $middle_middle,
          'middleMiddleRightClass' => "",
          'middleMiddleRight' => ""
        ),
        'middleBottom' => NULL
      ),
      'bottom' => array(
        'enable' => true,
        'value' => NULL
      )
    );

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   */
  public function getBlockMultiTabs($option = array(), $tabs_value = array()) {
    $output = array(
      "blockId" => 67,
      "class" => "col-md-12",
      "type" => "multiTabs",
      "blockClasses" => "",
      "top" => array(
        "enable" => true,
        "value" => "Multi Tabs"
      ),
      "middle" => array(
        "enable" => true,
        "value" => $tabs_value,
      ),
      "bottom" => array(
        "enable" => true,
        "value" => "<div>Multi Tabs Bottom</div>"
      )
    );

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   */
  public function chartNewJsOptions() {
    $output = array(
      "animation" => true,
      'animationSteps'=> 50,
      "annotateClassName" => "my11001799tooltip",
      "annotateDisplay" => true, //onhover value
      "annotateLabel" => "<%=v3%>",
      "datasetFill" => false,
      "datasetStrokeWidth" => 2,
      "inGraphDataBordersXSpace" => 12,
      "inGraphDataBordersYSpace" => 7,
      "inGraphDataFontColor" => "#163c52",
      "inGraphDataFontSize" => 15,
      "inGraphDataFontStyle" => "normal normal",
      "inGraphDataPaddingY" => 15,
      "inGraphDataShow" => true,
      "inGraphDataTmpl" => "<%=v3%>",
      "maxLegendCols" => 5, //maximum legend columns
      "responsive" => true,
      "responsiveMaxHeight" => 357,
      "responsiveMinHeight" => 280,
      "spaceBottom" => 10,
      "spaceTop" => 10,
      "legend" => false,
      "legendBlockSize" => 14,
      "legendBorders" => false,
      "legendFontColor" => "#000",
      "legendFontFamily" => "Roboto,'Helvetica Neue',sans-serif",
      "legendPosX" => 2,
      "legendPosY" => 0,
      "legendSpaceAfterText" => 0,
      "legendSpaceBeforeText" => 10,
      "legendSpaceBetweenBoxAndText" => 9,
      "legendSpaceBetweenTextHorizontal" => 15,
      "legendSpaceBetweenTextVertical" => 28,
      "legendSpaceLeftText" => 18,
      "legendBlockSize" => 14,
    );

    return $output;
  }

  /**
   *
   *
   $chart_data = array(
     "labels" => [
       "IPF",
       "CTLD-ID",
       "Other"
     ],
     "datasets" => [
       array(
         "fillColor" => "#2FA9E0",
         "strokeColor" => "#ffffff",
         "pointColor" => "#05d23e",
         "pointStrokeColor" => "#fff",
         "data" => [
           20,
           14,
           12
         ],
         "title" => "Working Dx"
       ),
       array(
         "fillColor" => "#f24b99",
         "strokeColor" => "#ffffff",
         "pointColor" => "#05d23e",
         "pointStrokeColor" => "#fff",
         "data" => [
           22,
           15,
           19
         ],
         "title" => "Working Dx 666"
       )
     ]
   );
   */

  public function getChartBar($option = array(), $chart_data = array()) {
    $output = array(
      "chartId" => hexdec(substr(uniqid(), 0, 13)),
      "chartType" => "Bar",
      "chartClass" => "col-md-6",  // only render on getBlockMultiContainer
      "chartTitle" => "Identify and address only render on getBlockMultiContainer",         // do we need this one
      "chartData" => $chart_data
    );

    $output["chartOptions"] = $this->chartNewJsOptions();
    $output["chartOptions"]["barBorderRadius"]  = 5;
    $output["chartOptions"]["barStrokeWidth"]  = 10;
    $output["chartOptions"]["barValueSpacing"]  = 10;
    $output["chartOptions"]["graphMax"] = 100;
    $output["chartOptions"]["graphMin"] = 0;
    $output["chartOptions"]["pointDotRadius"] = 6;
    $output["chartOptions"]["scaleFontSize"] = 14;
    $output["chartOptions"]["yAxisMinimumInterval"] = 10;
    $output["chartOptions"]["yScaleLabelsMinimumWidth"]  = 40;

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   * @return Array data
   */
  public function getChartLine($option = array(), $chart_data = array()) {
    $output = array(
      "chartId" => hexdec(substr(uniqid(), 0, 13)),
      "chartClass" => "col-md-6 opacity-05",
      "chartType" => "Line",
      "chartTitle" => "Line Chart",
      "chartData" => $chart_data
    );

    $output["chartOptions"] = $this->chartNewJsOptions();
    $output["chartOptions"]["barValueSpacing"] = 20;
    $output["chartOptions"]["bezierCurveTension"] = 0.2;
    $output["chartOptions"]["graphMax"] = 100;
    $output["chartOptions"]["graphMin"] = 0;
    $output["chartOptions"]["inGraphDataShow"] = false;
    $output["chartOptions"]["maxLegendCols"] = 1;
    $output["chartOptions"]["pointDotRadius"] = 6;
    $output["chartOptions"]["percentageInnerCutout"] = 99;
    $output["chartOptions"]["scaleFontSize"] = 14;
    $output["chartOptions"]["legendPosX"] = 4;
    $output["chartOptions"]["legendPosY"] = -2;
    $output["chartOptions"]["legendSpaceLeftText"] = 18;
    $output["chartOptions"]["yAxisLabel"] = "Number of events";
    $output["chartOptions"]["yAxisMinimumInterval"] = 20;
    $output["chartOptions"]["yScaleLabelsMinimumWidth"] = 40;

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   *
   *
    $chartData = [
      array(
       'value' => 5,
       'color' => "#f3f3f3",
       'title' => "Yes"
      ),
      array(
       'value' => 65,
       'color' => "#1aaadb",
       'title' => "No"
      )
    ],
   */
  public function getChartDoughnut($option = array(), $chart_data = array()) {
    $output = array(
      'chartId' => hexdec(substr(uniqid(), 0, 13)),
      'chartType' => "Doughnut",
      'chartData' => $chart_data
    );

    $output["chartOptions"] = $this->chartNewJsOptions();
    $output["chartOptions"]["annotateDisplay"] = false;
    $output["chartOptions"]["barValueSpacing"] = 20;
    $output["chartOptions"]["bezierCurveTension"] = 0.1;
    $output["chartOptions"]["crossText"] = ["", "Confirmed", "82%"];
    $output["chartOptions"]["crossTextAlign"] = ["center"];
    $output["chartOptions"]["crossTextBaseline"] = ["middle"];
    $output["chartOptions"]["crossTextFontColor"] = ["black"];
    $output["chartOptions"]["crossTextFontSize"] = [0,30,30];
    $output["chartOptions"]["crossTextIter"] = ["last"];
    $output["chartOptions"]["crossTextOverlay"] = [true];
    $output["chartOptions"]["crossTextPosX"] = [0,0,0];
    $output["chartOptions"]["crossTextPosY"] = [0,20,-30];
    $output["chartOptions"]["crossTextRelativePosX"] = [0,2,2];
    $output["chartOptions"]["crossTextRelativePosY"] = [0,2,2];
    $output["chartOptions"]["inGraphDataShow"] = false;
    $output["chartOptions"]["percentageInnerCutout"] = 90;
    $output["chartOptions"]["pointDotRadius"] = 6;
    $output["chartOptions"]["yAxisMinimumInterval"] = 20;

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   * chart_data = array(
      array(
        "value" => 12,
        "color" => "#2fa9e0",
        "title" => "1(12)"
      ),
      array(
        "value" => 28,
        "color" => "#f24b99",
        "title" => "2(28)"
      ),
      array(
        "value" => 9,
        "color" => "#37d8b3",
        "title" => "3(9)"
      ),
      array(
        "value" => 5,
        "color" => "#bfbfbf",
        "title" => "4(5)"
      )
    );
   */
  public function getChartPie($option = array(), $chart_data = array()) {
    $output = array(
      "chartId" => hexdec(substr(uniqid(), 0, 13)),
      "chartType" => "Pie",
      "chartClass" => "col-md-6 opacity-05",  // only render on getBlockMultiContainer
      "chartTitle" => "Identify and address only render on getBlockMultiContainer",
      "chartData" => $chart_data
    );

    $output["chartOptions"] = $this->chartNewJsOptions();
    $output["chartOptions"]["barValueSpacing"] = 0;
    $output["chartOptions"]["barValueSpacing"] = 0;
    $output["chartOptions"]["bezierCurveTension"] = 0.1;
    $output["chartOptions"]["inGraphDataAlign"] = "center";
    $output["chartOptions"]["inGraphDataAnglePosition"] = 2;
    $output["chartOptions"]["inGraphDataFontColor"] = "#ffffff";
    $output["chartOptions"]["inGraphDataPaddingRadius"] = 25;
    $output["chartOptions"]["inGraphDataRadiusPosition"] = 2;
    $output["chartOptions"]["inGraphDataTmpl"] = "<%=(Math.round(v6))+'%'%>";
    $output["chartOptions"]["percentageInnerCutout"] = 99; //inner cut area
    $output["chartOptions"]["pointDotRadius"] = 6;
    $output["chartOptions"]["title"] = "";
    $output["chartOptions"]["yAxisMinimumInterval"] = 20;

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   */
  public function getCommonTable($option = array(), $value = NULL) {
    if (!$value) {
      $value = array(
        "thead" => [
          [
            "Speciality",
            "Number",
            "Percentage"
          ]
        ],
        "tbody" => [
          [
            "Family Physician",
            818800,
            "55%"
          ],
          [
            "Pharmacist",
            15,
            "10%"
          ],
          [
            "Nurse",
            15,
            "10%"
          ],
          [
            "Diabetes Nurse Educator",
            7,
            "5%"
          ],
          [
            "Other",
            7,
            "5%"
          ],
          [
            "Dietitian",
            6,
            "4%"
          ],
          [
            "Nurse Practitioner",
            6,
            "4%"
          ],
          [
            "Resident",
            3,
            "2%"
          ],
          [
            "Internist",
            3,
            "2%"
          ],
          [
            "Endocrinologist",
            2,
            "1%"
          ],
          [
            "Anesthesiologists",
            1,
            "1%"
          ]
        ]
      );
    }

    $output = array(
      "class" => "font-size-12",
      "tableSettings" => array(
        "pagination" => true,
        "searchFilter" => true,
        "paginationType" => "full_numbers",
        "searchPlaceholder" => "SEARCH"
      ),
      "value" => $value,
    );

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   */
  public function getGoogleMap($option = array(), $value = NULL) {
    $output = array(
      "class" => "col-md-12",
      "value" => $value,
    );

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   */
  public function setBlockProperty($output = array(), $option = array()) {
    if (is_array($option)) {
      foreach ($option as $key => $value) {
        if (array_key_exists($key, $output)) {
          if (is_array($value)) {
            $output[$key] = $this->setBlockProperty($output[$key], $value);
          }
          else {
            $output[$key] = $value;
          }
        }
      }
    }

    return $output;
  }

}

/**
 * An example controller.
 $DashpageJsonGenerator = new DashpageJsonGenerator();
 $DashpageJsonGenerator->angularJson();
 */
class DashpageJsonGenerator extends JsonDashpageBase {

  /**
   *
   */
  public function angularJson() {
    $this->setPostUrl('page/forms/preform/add');

    // $output['fixedSection'] = array(
    //   $this->getTileStyleOne(array('value' => array('header' => array('class' => 'bg-2fa9e0 color-fff'))), 'Total Registrations', 128),
    //   $this->getTileStyleOne(array('value' => array('header' => array('class' => 'bg-f34b99 color-fff'))), 'Total Referrals', 360),
    //   $this->getTileStyleOne(array('value' => array('header' => array('class' => 'bg-99dc3b color-fff'))), 'Number of Sessions', 96),
    //   $this->getTileStyleOne(array('value' => array('header' => array('class' => 'bg-f3c848 color-fff'))), 'Overall Satisfaction', 4.5),
    // );

    $bar_chart_data = array(
      "labels" => array(
        "IPF",
        "CTLD-ID",
        "Other"
      ),
      "datasets" => array(
        array(
          "fillColor" => "#2FA9E0",
          "strokeColor" => "#ffffff",
          "pointColor" => "#05d23e",
          "pointStrokeColor" => "#fff",
          "data" => array(
            20,
            14,
            12
          )
        ),
        array(
          "fillColor" => "#f24b99",
          "strokeColor" => "#ffffff",
          "pointColor" => "#05d23e",
          "pointStrokeColor" => "#fff",
          "data" => array(
            22,
            15,
            19
          )
        )
      )
    );
    $line_chart_data = array(
      "labels" => array(
        "JAN",
        "FEB",
        "MAR",
        "APR",
        "MAY",
        "JUN",
        "JUL",
        "AUG",
        "SEP",
        "OCT",
        "NOV",
        "DEC"
      ),
      "datasets" => array(
        array(
          "fillColor" => "rgba(151,187,205,0)",
          "strokeColor" => "#f24b99",
          "pointColor" => "#f24b99",
          "pointStrokeColor" => "#fff",
          "data" => array(
            6,
            8,
            2,
            9,
            19,
            1,
            15,
            15,
            4,
            6,
            9,
            13
          )
        ),
        array(
          "fillColor"=> "#00a9e0",
          "strokeColor"=> "#00a9e0",
          "pointColor"=> "#00a9e0",
          "pointStrokeColor"=> "#fff",
          "data"=> array(
            12,
            13,
            3,
            7,
            13,
            16,
            17,
            11,
            18,
            4,
            23,
            26
          )
        )
      )
    );
    $doughnut_chart_data = array(
      array(
        "value" => 5,
        "color" => "#f3f3f3",
        "title" => "Yes"
      ),
      array(
        "value" => 65,
        "color" => "#1aaadb",
        "title" => "No"
      )
    );
    $pie_chart_data = array(
      array(
        "value" => 12,
        "color" => "#2fa9e0",
        "title" => "1(12)"
      ),
      array(
        "value" => 28,
        "color" => "#f24b99",
        "title" => "2(28)"
      ),
      array(
        "value" => 9,
        "color" => "#37d8b3",
        "title" => "3(9)"
      ),
      array(
        "value" => 5,
        "color" => "#bfbfbf",
        "title" => "4(5)"
      )
    );
    $output['contentSection'] = array(
      // $this->getBlockOne(array('class' => "col-md-12", 'type' => "commonTable"), $this->getCommonTable()),

      $this->getBlockOne(array('class' => "col-md-6"), $this->getChartDoughnut(NUll, $doughnut_chart_data)),
      $this->getBlockOne(array('class' => "col-md-6"), $this->getChartDoughnut(NUll, $doughnut_chart_data)),
      $this->getBlockOne(array('class' => "col-md-6"), $this->getChartPie(array("chartId" => "3714520699999"), $pie_chart_data)),
      $this->getBlockOne(array('class' => "col-md-6"), $this->getChartPie(array("chartId" => "3714520694566"), $pie_chart_data)),

      $this->getBlockOne(array('class' => "col-md-12"), $this->getChartBar(array("chartId" => "3714462764879"), $bar_chart_data)),
      $this->getBlockOne(array('class' => "col-md-12"), $this->getChartLine(array("chartId" => "3714520642366"),  $line_chart_data)),

      // $this->getBlockMultiTabs(
      //   NULL,
      //   array(
      //     $this->getBlockTabContainer(array('class' => "col-md-12"), $this->getChartDoughnut()),
      //     $this->getBlockTabContainer(array('class' => "col-md-12"), $this->getChartBar()),
      //     $this->getBlockTabContainer(array('class' => "col-md-12"), $this->getChartBar()),
      //     $this->getBlockTabContainer(array('class' => "col-md-12"), $this->getChartBar())
      //   )
      // ),
      // $this->getBlockOne(
      //   array('class' => "col-md-12", 'type' => "multiContainer"),
      //   array(
      //     $this->getChartBar(array("chartId" => "37145265","chartClass" => "col-md-6")),
      //     $this->getChartPie(array("chartId" => "371872879","chartClass" => "col-md-6"))
      //   )
      // )
    );

    return $output;
  }

}
