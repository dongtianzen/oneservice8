<?php

/**
 * @file
 * Contains \Drupal\dashpage\Content\DashpageObjectContent.
 */

namespace Drupal\dashpage\Content;

use Drupal\Core\Url;
use Drupal\Component\Utility\Unicode;

use Drupal\dashpage\Content\DashpageEventLayout;

/**
 *
 */
class DashpageGridContent {

  public function meetingNodesByMonth($meeting_nodes = array(), $months = array()) {
    $output = array();

    if (is_array($meeting_nodes)) {
      foreach($meeting_nodes as $node) {

        $date_time = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($node, 'field_quote_date');
        if ($date_time) {

          preg_match("/^20\d\d\-(\d\d)/i", $date_time, $matches);
          if (isset($matches[1])) {

            $month_num = $matches[1];
            if (in_array($month_num, $months)) {
              $output[] = $node;
            }
          }
        }
      }
    }

    return $output;
  }

  /**
   * $month_label[] = t(date('M', mktime(0, 0, 0, $i)));
   * array(t('JAN'), t('FEB'), t('MAR'), t('APR'), t('MAY'), t('JUN'), t('JUL'), t('AUG'), t('SEP'), t('OCT'), t('NOV'), t('DEC'));
   */
  public function gridByMonth($meeting_nodes = array(), $count_field = NULL) {
    for ($i = 1; $i < 13; $i++) {
      $month_label[] = t(date('M', mktime(0, 0, 0, $i)));
      $month_nodes = $this->meetingNodesByMonth($meeting_nodes, array($i));
      $month_data[]  = \Drupal::getContainer()->get('flexinfo.calc.service')->getSumFromNodes($month_nodes, $count_field);
    }

    $output['label'] = $month_label;
    $output['data'] = $month_data;

    return $output;
  }

}

/**
 *
 */
class DashpageBlockContent extends DashpageGridContent{

  /**
   *
   */
  public function blockReportSnapshot($meeting_nodes = array(), $entity_id = NULL, $page_view = NULL) {
    $DashpageJsonGenerator = new DashpageJsonGenerator();

    $meeting_nodes = \Drupal::entityManager()->getStorage('node')->loadMultiple(array(440, 441));
    // month
    $month_grid = $this->gridByMonth($meeting_nodes);
    $month_tab = \Drupal::getContainer()->get('flexinfo.chart.service')->renderChartLineDataSet($month_grid['data'], $month_grid['label']);

    $block_content[] = $DashpageJsonGenerator->getBlockTabContainer(
      array('title' => t('MONTH'), ),
      $DashpageJsonGenerator->getChartLine(
        array(
          "chartOptions" => array('yAxisLabel' => "Number of Quote"),
        ),
        $month_tab
      )
    );

    // block option
    $block_option = array(
      'top'  => array(
        'value' => t('Total Reach (All Business Units)'),          // block top title value
      ),
    );

    $output = $DashpageJsonGenerator->getBlockMultiTabs(
      $block_option,
      $block_content
    );

    return $month_tab;
  }

  /**
   *
   */
  public function blockPhpTableWebinarSchedule($table_content = array(), $block_title = 'Event Table') {
    $DashpageJsonGenerator = new DashpageJsonGenerator();
    $output = $DashpageJsonGenerator->getBlockOne(
      array(
        'class' => "col-md-12",
        'blockClasses' => "height-400 overflow-visible",
        'type' => "commonPhpTable",
        'top' => array(
          'value' => 'commonPhpTable'
        )
      ),
      $DashpageJsonGenerator->getCommonTable(NUll, NULL)
    );

    return $output;
  }

  /**
   *
   */
  public function blockTableGenerate($table_content = array(), $block_title = 'Event Table') {
    // block option
    $block_option = array(
      'class' => "col-md-12",
      'blockClasses' => "height-400 overflow-visible",
      'type' => "commonTable",
      'top'  => array(
        'enable' => FALSE,
      ),
    );

    $DashpageJsonGenerator = new DashpageJsonGenerator();
    $output = $DashpageJsonGenerator->getBlockOne(
      $block_option,
      $DashpageJsonGenerator->getCommonTable(NULL, $table_content)
    );

    return $output;
  }

  /**
   *
   */
  public function blockTableEventStatus($meeting_nodes = array(), $entity_id = 'all') {
    $table_content = \Drupal::getContainer()
      ->get('flexinfo.chart.service')->convertContentToTableArray($this->tableEventStatus($meeting_nodes));

    $output = $this->blockMildderTableGenerate($table_content, t('Event Status'));

    return $output;
  }

  /**
   *
   */
  public function blockTileWebinarSchedule($meeting_nodes = array(), $entity_id = 'all') {
    $table_content = \Drupal::getContainer()
      ->get('flexinfo.chart.service')->convertContentToTableArray($this->tableWebinar($meeting_nodes));

    $DashpageJsonGenerator = new DashpageJsonGenerator();

    $output = $DashpageJsonGenerator->getBlockMultiContainer(
      array(
        'class' => "col-sm-12",
        'top' => array('enable' => false),
        'middle' => array(
          'middleTop' => 'getBlockTabContainer-Bottom',
          'middleBottom' => 'getBlockTabContainer-Bottom',
        ),
      ),
      array(
        $DashpageJsonGenerator->getBlockHtmlSnippet(
          array(
            'class' => "col-xs-12 col-lg-5",
            "top" => array("enable" => false)
          ),
          $DashpageJsonGenerator->dashpageTaskList()
        ),

        $DashpageJsonGenerator->getBlockOne(
          array(
            'class' => "col-lg-2 col-sm-4 padding-10",
            'middle' => array(
              'middleTop' => '<span class="col-xs-12 padding-0"><span class="color-009ddf text-align-center">Webinar Participation</span></span>',
              'middleBottom' => '<span class="color-a5d23e  display-block text-align-center">Sessions Attended<span class="color-b5b5b5 padding-left-4">(6)</span></span>',

            ),
          ),
          $DashpageJsonGenerator->getChartDoughnut(NUll, $DashpageJsonGenerator->generateSampleData("doughnut_chart_data"))
        ),

        $DashpageJsonGenerator->getBlockOne(
          array(
            'class' => "col-lg-2 col-sm-4 padding-10",
            'middle' => array(
              'middleTop' => '<span class="visibility-hidden">Webinar Participation</span>',
              'middleBottom' => '<span class="color-009ddf display-block text-align-center">Sessions Remaining<span class="color-b5b5b5 padding-left-4">(4)</span></span>',

            ),
          ),
          $DashpageJsonGenerator->getChartDoughnut(
            array(
              'chartOptions' => array(
                'crossText' => array('','','45%'),
              )
            ),
            $DashpageJsonGenerator->generateSampleData("doughnut_chart_data2")
          )
        ),
        $DashpageJsonGenerator->getBlockOne(
          array(
            'class' => "col-lg-2 col-sm-4 padding-10",
            'middle' => array(
              'middleTop' => '<span class="visibility-hidden">Webinar Participation</span>',
              'middleBottom' => '<span class="color-ec247f  display-block text-align-center">Sessions Missed<span class="color-b5b5b5 padding-left-4">(2)</span></span>',
            ),
          ),
          $DashpageJsonGenerator->getChartDoughnut(
            array(
              'chartOptions' => array(
                'crossText' => array('','','16%'),
              )
            ),
            $DashpageJsonGenerator->generateSampleData("doughnut_chart_data3")
          )
        ),
      )
    );

    return $output;
  }

}

/**
 * @return php object, not JSON
 */
class DashpageObjectContent extends DashpageBlockContent {

  /**
   * @return php object, not JSON
   */
  public function reportSnapshotObjectContent($meeting_nodes = array()) {
    $output['contentSection'][] = $this->blockReportSnapshot();

    return $output;
  }

}
