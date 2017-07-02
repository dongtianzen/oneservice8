<?php

/**
 * @file
 * Contains \Drupal\dashpage\Controller\DashpageJsonGenerator.
 */

namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 *
 */
class JsonDashpageBase {
  private $post_url = NULL;

  public function getPostUrl() {
    return $this->post_url;
  }

  public function setPostUrl($value = NULL) {
    $this->post_url = $value;
  }

  /**
   *
   */
  public function generateUniqueId() {
    $output = hexdec(substr(uniqid(NULL, TRUE), 15, 8));
    return $output;
  }

  /**
   *
   */
  public function generateSampleData($data_type = NULL) {
    $bar_chart_data = array(
      "labels" => array(
        "1",
        "2",
        "3",
        "4",
        "5"
      ),
      "datasets" => array(
        array(
          "fillColor" => ["#56bfb5","#f24b99","#344a5f","#bfbfbf","#e6e6e6"],
          "strokeColor" => ["#56bfb5","#f24b99","#344a5f","#bfbfbf","#e6e6e6"],
          "pointColor" => "#05d23e",
          "pointStrokeColor" => "#fff",
          "data" => array(
            500,
            140,
            14,
            12
          ),
        ),
        array(
          "fillColor" => "#f24b99",
          "strokeColor" => "#ffffff",
          "pointColor" => "#05d23e",
          "pointStrokeColor" => "#fff",
          "data" => array(
            35,
            // 15,
            // 15,
            // 19
          ),
        )

      )
    );

    $pie_chart_data = array(
      array(
        "value" => 45,
        "color" => "#2fa9e0",
        "title" => "1(12)"
      ),
      array(
        "value" => 12,
        "color" => "#f24b99",
        "title" => "2(28)"
      ),
      array(
        "value" => 32,
        "color" => "#37d8b3",
        "title" => "3(9)"
      ),
      array(
        "value" => 15,
        "color" => "#bfbfbf",
        "title" => "4(5)"
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

    $table_data = array(
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
          "Endocrinologist",
          2,
          "1%"
        ],
        [
          "Endocrinologist",
          2,
          "1%"
        ],
        [
          "Endocrinologist",
          2,
          "1%"
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

    $output = $$data_type;
    return $output;
  }

  /** - - - - - field- - - - - - - - - - - - - - - */
  /**
   *
   */
  public function getTileStyleOne($option = array(), $value = NULL, $value_one = NULL) {
    $output = array(
      'blockId' => $this->generateUniqueId(),
      'class' => "col-md-3 col-xs-6 padding-0",
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
  public function getHtmlSnippet($option = array(), $value = NULL) {
    $output = array(
      'blockId' => $this->generateUniqueId(),
      'class' => "col-md-12",
      'type'  => "htmlSnippet",
      'value' => $value,   // <div>Multi-Chart-Middle-Top</div>
    );

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   */
  public function getBlockHtmlSnippet($option = array(), $value = NULL) {
    $output = array(
      'blockId' => $this->generateUniqueId(),
      'class' => "col-md-12",
      'blockClasses' => "",
      'type' => "htmlSnippet",          // chart or multiContiner, commonTable, googleMap
      'top'  =>  array(
        'enable' => TRUE,
        'value' => NULL,          // block top title value
      ),
      'middle' =>  array(
        'enable' => TRUE,
        'value' => $value,     // <div>Multi-Chart-Middle-Top</div>
      )
    );

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   */
  public function getBlockOne($option = array(), $middle_middle_value = array()) {
    $output = array(
      'blockId' => $this->generateUniqueId(),
      'class' => "col-md-12",
      'blockClasses' => "height-400 overflow-hidden position-relative",
      'type' => "chart",          // chart or multiContiner, commonTable, googleMap
      'top'  =>  array(
        'enable' => TRUE,
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
        'middleBottom' => "",   // block middleBottom HTML value, "<div>Multi-Chart-Middle-Bottom</div>"
      ),
      'bottom' => array(
        'enable' => TRUE,
        'value' => NULL,          // block Bottom HTML value, "<div>Multi-Chart-Bottom</div>"
      )
    );

    $output = $this->setBlockProperty($output, $option);
    $output = $this->setContentMaxHeight($output);

    return $output;
  }

  public function setContentMaxHeight($output = array()) {
    $pattern = '/height\-(\d+)/';
    if ($output['middle']['middleBottom']) {
    }

    if (isset($output['blockClasses'])) {
      preg_match($pattern, $output['blockClasses'], $matches);
      if (isset($matches[1])) {
        if (isset($output['middle']['middleMiddle']['middleMiddleMiddle']['chartOptions']['responsiveMaxHeight'])) {
          if ($output['middle']['middleMiddle']['middleMiddleMiddle']['chartOptions']['responsiveMaxHeight'] >= $matches[1]) {

            // if bottom exists
            if ($output['middle']['middleBottom']) {
              $output['middle']['middleMiddle']['middleMiddleMiddle']['chartOptions']['responsiveMaxHeight'] = $matches[1] - 66;
            }
            else {
              $output['middle']['middleMiddle']['middleMiddleMiddle']['chartOptions']['responsiveMaxHeight'] = $matches[1] - 30;
            }

          }
        }
      }
    }

    return $output;
  }

  /**
   *
   */
  public function getBlockTabContainer($option = array(), $middle_middle = NULL) {
    $output = array(
      'blockId' => $this->generateUniqueId(),
      'class' => "col-md-12",
      'title' => "Tab",
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
          'middleMiddleMiddleClass' => "",
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
  public function getBlockMultiContainer($option = array(), $middle_middle = NULL) {
    $output = array(
      'blockId' => $this->generateUniqueId(),
      'class' => "col-md-12",
      'blockClasses' => '',
      'type' => "multiContainer",          // chart or multiContiner, commonTable, googleMap
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
          'middleMiddleMiddle' => $middle_middle,
          'middleMiddleRightClass' => "",
          'middleMiddleRight' => ""
        ),
        'middleBottom' => "",   // block middleBottom HTML value, "<div>Multi-Chart-Middle-Bottom</div>"
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
  public function getBlockMultiTabs($option = array(), $tabs_value = array()) {
    $output = array(
      "blockId" => $this->generateUniqueId(),
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
        "value" => NULL
      )
    );

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   * @return Array data
   */
  public function chartNewJsOptions() {
    $output = array(
      "animation" => true,
      'animationSteps'=> 50,
      "annotateClassName" => "my11001799tooltip",
      "annotateDisplay" => TRUE, //onhover value
      "annotateLabel" => "<%=v2%>",
      "datasetFill" => false,
      "datasetStrokeWidth" => 2,
      "inGraphDataBordersXSpace" => 12,
      "inGraphDataBordersYSpace" => 7,
      "inGraphDataFontColor" => "#000",
      "inGraphDataFontSize" => 15,
      "inGraphDataFontStyle" => "normal normal",
      "inGraphDataPaddingY" => 5,
      "inGraphDataShow" => true,
      "inGraphDataTmpl" => "<%=v3%>",
      "maxLegendCols" => 5, //maximum legend columns
      "responsive" => true,
      "responsiveMaxHeight" => 480,
      "responsiveMinHeight" => 280,
      "spaceBottom" => 10,
      "spaceTop" => 20,
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
   * @return Array data
   */
  public function getChartBar($option = array(), $chart_data = array()) {
    $output = array(
      "chartId" => $this->generateUniqueId(),
      "chartType" => "Bar", // Bar or HorizontalBar or HorizontalStackedBar
      "chartClass" => "",  // only render on getBlockMultiContainer
      "chartTitle" => "Identify and address only render on getBlockMultiContainer",         // do we need this one
      "chartData" => $chart_data
    );

    $number_of_labels = 0;
    if (isset($chart_data['labels'])) {
      $number_of_labels = count($chart_data['labels']);
    }
    // dynamic bar value spacing according to labels in the chart.

    $bar_value_spacing = 0;
    if ($number_of_labels > 0) {
      $bar_value_spacing = 160 / $number_of_labels;
    }

    $output["chartOptions"] = $this->chartNewJsOptions();

    // increase chart height on oncreased labels in chart
    if (isset($option["chartType"]) && $option["chartType"] == ('HorizontalStackedBar' || 'HorizontalBar')) {

      if ($number_of_labels > 0) {
        $bar_value_spacing = 120 / $number_of_labels;
        if ($number_of_labels > 4) {
          $output["chartOptions"]["responsiveMaxHeight"] = 600;
        }
      }
      if ($option["chartType"] == "HorizontalStackedBar") {
        $output["chartOptions"]["inGraphDataFontColor"] = "#fff";
      }
    }

    $output["chartOptions"]["annotateLabel"] = "<%=Math.round(100*(v3/grandtotal)) + \"%\"%>";
    // $output["chartOptions"]["annotateLabel"] = "<%=Math.round(v6) + \"%\" %>";

    $output["chartOptions"]["barValueSpacing"] = $bar_value_spacing;
    $output["chartOptions"]["barBorderRadius"] = 5;
    $output["chartOptions"]["barStrokeWidth"] = 2;
    $output["chartOptions"]["graphMin"] = 0;
    // $output["chartOptions"]["graphMax"] = 100;
    $output["chartOptions"]["inGraphDataTmpl"] = "<%=(v3 < 1) ? \"\"  : v3%>";
    $output["chartOptions"]["pointDotRadius"] = 6;
    $output["chartOptions"]["scaleFontSize"] = 14;
    $output["chartOptions"]["spaceTop"] = 30;
    $output["chartOptions"]["yAxisMinimumInterval"] = 10;
    $output["chartOptions"]["yScaleLabelsMinimumWidth"] = 40;

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   * @return Array data
   */
  public function getChartLine($option = array(), $chart_data = array()) {
    $output = array(
      "chartId" => $this->generateUniqueId(),
      "chartClass" => "col-md-6 opacity-05",
      "chartType" => "Line",
      "chartTitle" => "Line Chart",
      "chartData" => $chart_data
    );

    $output["chartOptions"] = $this->chartNewJsOptions();
    $output["chartOptions"]["annotateLabel"] = "<%=v3%>";
    $output["chartOptions"]["barValueSpacing"] = 20;
    $output["chartOptions"]["bezierCurveTension"] = 0.2;
    // $output["chartOptions"]["graphMax"] = 100;
    $output["chartOptions"]["graphMin"] = 0;
    $output["chartOptions"]["inGraphDataShow"] = true;
    $output["chartOptions"]["inGraphDataTmpl"] = "<%=Math.round(v3)%>";
    $output["chartOptions"]["maxLegendCols"] = 1;
    $output["chartOptions"]["pointDotRadius"] = 6;
    $output["chartOptions"]["percentageInnerCutout"] = 99;
    $output["chartOptions"]["scaleFontSize"] = 14;
    $output["chartOptions"]["legendPosX"] = 4;
    $output["chartOptions"]["legendPosY"] = -2;
    $output["chartOptions"]["legendSpaceLeftText"] = 18;
    $output["chartOptions"]["yAxisLabel"] = "Number of Events";
    $output["chartOptions"]["yAxisMinimumInterval"] = 20;
    $output["chartOptions"]["yScaleLabelsMinimumWidth"] = 40;

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   */
  public function getChartDoughnut($option = array(), $chart_data = array()) {
    $output = array(
      'chartId' => $this->generateUniqueId(),
      'chartType' => "Doughnut",
      'chartData' => $chart_data
    );

    $output["chartOptions"] = $this->chartNewJsOptions();
    $output["chartOptions"]["annotateDisplay"] = true;
    $output["chartOptions"]["annotateLabel"] = "<%=v2%>";
    $output["chartOptions"]["barValueSpacing"] = 20;
    $output["chartOptions"]["bezierCurveTension"] = 0.1;
    $output["chartOptions"]["crossText"] = ["", "", ""];
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
   *
   */
  public function getChartPie($option = array(), $chart_data = array()) {
    $output = array(
      "chartId" => $this->generateUniqueId(),
      "chartType" => "Pie",
      "chartClass" => "col-md-6 opacity-05",  // only render on getBlockMultiContainer
      "chartTitle" => "Identify and address only render on getBlockMultiContainer",
      "chartData" => $chart_data
    );

    $output["chartOptions"] = $this->chartNewJsOptions();

    $output["chartOptions"]["annotateLabel"] = "<%=v2%>";
    $output["chartOptions"]["barValueSpacing"] = 0;
    $output["chartOptions"]["barValueSpacing"] = 0;
    $output["chartOptions"]["bezierCurveTension"] = 0.1;
    $output["chartOptions"]["inGraphDataTmpl"] = "<%=Math.round(v6 < 5) ? \"\" : Math.round(v6) + \"%\"%>";
    $output["chartOptions"]["inGraphDataAlign"] = "center";
    $output["chartOptions"]["inGraphDataAnglePosition"] = 2;
    $output["chartOptions"]["inGraphDataFontColor"] = "#ffffff";
    $output["chartOptions"]["inGraphDataPaddingRadius"] = 25;
    $output["chartOptions"]["inGraphDataRadiusPosition"] = 2;
    $output["chartOptions"]["percentageInnerCutout"] = 99; //inner cut area
    $output["chartOptions"]["pointDotRadius"] = 6;
    $output["chartOptions"]["title"] = "";
    $output["chartOptions"]["yAxisMinimumInterval"] = 20;


    // default inGraphDataType is percentage
    // if (isset($option["inGraphDataType"])) {
    //   if ($option["inGraphDataType"] == 'value') {
    //     $output["chartOptions"]["inGraphDataTmpl"] = "<%=v2%>";
    //     $output["chartOptions"]["annotateLabel"] = "<%=(Math.round(v6))+'%'%>";
    //   }
    // }

    $output = $this->setBlockProperty($output, $option);

    return $output;
  }

  /**
   *
   */
  public function getCommonTable($option = array(), $table_data = array()) {
    $output = array(
      "class" => "font-size-12",
      "tableSettings" => array(
        "pagination" => true,
        "searchFilter" => true,
        "paginationType" => "full_numbers",
        "searchPlaceholder" => "SEARCH"
      ),
      "value" => $table_data,
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
      'type' => "googleMap",
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
 */
class DashpageJsonGenerator extends JsonDashpageBase {

  /**
   *
   */
  public function angularJson() {
    $this->setPostUrl('page/forms/preform/add');

    $output['fixedSection'] = array(
      $this->getTileStyleOne(array('value' => array('header' => array('class' => 'bg-2fa9e0 color-fff'))), 'Total Registrations', 128),
      $this->getTileStyleOne(array('value' => array('header' => array('class' => 'bg-f34b99 color-fff'))), 'Total Referrals', 360),
      $this->getTileStyleOne(array('value' => array('header' => array('class' => 'bg-99dc3b color-fff'))), 'Number of Sessions', 96),
      $this->getTileStyleOne(array('value' => array('header' => array('class' => 'bg-f3c848 color-fff'))), 'Overall Satisfaction', 4.5),
      $this->getHtmlSnippet(array('class' => "col-md-12"), "<div>Multi-Chart-Middlwwwwwettom</div>"),
    );

    $bottom_value = NULL;
    $bottom_value .= '<div class="col-md-12 padding-0 position-absolute bottom-0">';
      $bottom_value .= '<div class="col-md-6 height-66 border-1-eee text-align-center">NTS</div>';
      $bottom_value .= '<div class="col-md-6 height-66 border-1-eee text-align-center">RESPONSES</div>';
    $bottom_value .= '</div>';

    $legends = NULL;
    $legends .= '<div class="margin-top-150">';
      $legends .= '<span class="legend-square bg-00a9e0"></span>5<br>';
      $legends .= '<span class="legend-square bg-00a9e0"></span>4<br>';
      $legends .= '<span class="legend-square bg-00a9e0"></span>3<br>';
      $legends .= '<span class="legend-square bg-00a9e0"></span>2<br>';
      $legends .= '<span class="legend-square bg-00a9e0"></span>1<br>';
    $legends .= '</div>';


    $output['contentSection'] = array(
      // $this->getBlockHtmlSnippet(array('class' => "col-md-12"), "<div>Multi-Chart-Middlwwwwwettom</div>"),

      // common table
      // $this->getBlockOne(
      //   array(
      //     'class' => "col-md-12",
      //     'type' => "commonTable",
      //     'blockClasses' => "height-400 overflow-visible"
      //   ),
      //   $this->getCommonTable(NUll, $this->generateSampleData("table_data"))
      // ),

      // php table

      // $this->getBlockOne(
      //   array(
      //     'class' => "col-md-12",
      //     'blockClasses' => "height-400 overflow-visible",
      //     'type' => "commonPhpTable",
      //     'top' => array(
      //       'value' => 'commonPhpTable'
      //     )
      //   ),
      //   $this->getCommonTable(NUll, NULL)
      // ),


      // $this->getBlockOne(
      //   array('class' => "col-md-12"),
      //   $this->getHtmlSnippet(NUll, "<div>Multi-Chart-Middle-Bottom</div>")
      // ),

      // $this->getBlockOne(
      //   array(
      //     'class' => "col-md-6",
      //     'middle' => array(
      //       'middleBottom' => 'middleBottom-Chart-Bottom',
      //     ),
      //     'bottom' => array(
      //       'value' => 'Multi-Chart-Bottom',
      //     )
      //   ),
      //   $this->getChartDoughnut(NUll, $this->generateSampleData("doughnut_chart_data"))
      // ),
      // $this->getBlockOne(array('class' => "col-md-4"), $this->getChartDoughnut(NUll, $this->generateSampleData("doughnut_chart_data"))),
      // $this->getBlockOne(
      //   array(
      //     'class' => "col-md-6",
      //     'middle' => array(
      //       'middleMiddle' => array(
      //         'middleMiddleMiddleClass' => "col-md-9",
      //         'middleMiddleRightClass' => "col-md-3",
      //         'middleMiddleRight' => $legends,
      //       ),
      //       'middleBottom' => $bottom_value,
      //     )
      //   ),
      //   $this->getChartLine(NUll, $this->generateSampleData("line_chart_data")

      //   )
      // ),
      // $this->getBlockOne(
      //   array(
      //     'class' => "col-md-6",
      //     'middle' => array(
      //       'middleMiddle' => array(
      //         'middleMiddleMiddleClass' => "col-md-9",
      //         'middleMiddleRightClass' => "col-md-3",
      //         'middleMiddleRight' => $legends,
      //       ),
      //       'middleBottom' => $bottom_value,
      //     )
      //   ),
      //   $this->getChartPie(NUll,
      //     $this->generateSampleData(
      //       "pie_chart_data"
      //     )
      //   )
      // ),
      // $this->getBlockOne(
      //   array(
      //     'class' => "col-md-4",
      //     'middle' => array(
      //       'middleMiddle' => array(
      //         'middleMiddleMiddleClass' => "",
      //         'middleMiddleRightClass' => "",
      //         'middleMiddleRight' => "",
      //       ),
      //       'middleBottom' => $bottom_value,
      //     )
      //   ),
      //   $this->getChartDoughnut(NUll,
      //     $this->generateSampleData(
      //       "doughnut_chart_data"
      //     )
      //   )
      // ),
      // $this->getBlockOne(
      //   array(
      //     'class' => "col-md-4",
      //     'middle' => array(
      //       'middleMiddle' => array(
      //         'middleMiddleMiddleClass' => "",
      //         'middleMiddleRightClass' => "",
      //         'middleMiddleRight' => "",
      //       ),
      //       'middleBottom' => $bottom_value,
      //     )
      //   ),
      //   $this->getChartPie(NUll,
      //     $this->generateSampleData(
      //       "pie_chart_data"
      //     )
      //   )
      // ),
      // $this->getBlockOne(array('class' => "col-md-12", 'type' => "googleMap"), $this->getGoogleMap())

      $this->getBlockOne(array('class' => "col-md-4"), $this->getChartBar(array("chartType" => "Bar"), $this->generateSampleData("bar_chart_data"))),
      $this->getBlockOne(array('class' => "col-md-4"), $this->getChartLine(NULL,  $this->generateSampleData("line_chart_data"))),

      $this->getBlockMultiTabs(
        array(
          "class" => "col-md-4"
        ),
        array(
          $this->getBlockTabContainer(
            array(
              'class' => "col-md-12",
              'type' => 'multiContainer',
              'middle' => array(
                'middleBottom' => '',
              ),
              'bottom' => array(
                'value' => '',
              )
            ),
            array(
              $this->getBlockOne(
                array(
                  'class' => "col-md-12",
                  'type' => "chart",
                  'middle' => array(
                    'middleMiddle' => array(
                      'middleMiddleMiddleClass' => "col-md-9",
                      'middleMiddleRightClass' => "col-md-3",
                      'middleMiddleRight' => $legends,
                    ),
                    'middleBottom' => $bottom_value,
                  ),
                  'bottom' => array(
                    'value' => '',
                  )
                ),
                $this->getChartPie(NUll,
                  $this->generateSampleData(
                    "pie_chart_data"
                  )
                )
              ),
              // $this->getBlockOne(
              //   array(
              //     'class' => "col-md-6",
              //     'type' => "chart",
              //     // 'middle' => array(
              //     //   'middleBottom' => 'middleBottom-Chart-Bottom',
              //     // ),
              //     'bottom' => array(
              //       'value' => 'Multi-Chart-Bottom',
              //     )
              //   ),
              //   $this->getChartBar(array("chartType" => "Bar"),
              //   $this->generateSampleData("bar_chart_data"))
              // )
            )
          ),
          // $this->getBlockTabContainer(
          //   array('class' => "col-md-12", 'type' => "googleMap"),
          //   $this->getGoogleMap()
          // ),
          $this->getBlockTabContainer(
            array(
              'class' => "col-md-12",
              'type' => 'chart',
              'middle' => array(
                'middleBottom' => 'middleBottom-Chart-Bottom',
              ),
              'bottom' => array(
                'value' => 'Multi-Chart-Bottom',
              )
            ),
            $this->getChartDoughnut(NUll, $this->generateSampleData("doughnut_chart_data"))
          ),
        )
      ),
      // $this->getBlockMultiContainer(
      //   array(
      //     'class' => "col-md-12",
      //     'middle' => array(
      //       'middleBottom' => 'getBlockTabContainer-Bottom',
      //     ),
      //     'bottom' => array(
      //       'value' => 'Multi-Chart-Bottom',
      //     )
      //   ),
      //   array(
      //     $this->getBlockOne(array('class' => "col-md-6", 'type' => "chart"), $this->getChartBar(array("chartType" => "Bar"), $this->generateSampleData("bar_chart_data"))),
      //     $this->getBlockOne(array('class' => "col-md-6", 'type' => "chart"), $this->getChartBar(array("chartType" => "Bar"), $this->generateSampleData("bar_chart_data"))),
      //     // $this->getBlockOne(array('class' => "col-md-6"), $this->getChartDoughnut(NUll, $this->generateSampleData("doughnut_chart_data"))),
      //     // $this->getBlockOne(array('class' => "col-md-6"), $this->getChartDoughnut(NUll, $this->generateSampleData("doughnut_chart_data"))),
      //   )
      // )
    );

    return $output;
  }

}
