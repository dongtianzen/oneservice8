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

  /**
   * $month_label[] = t(date('M', mktime(0, 0, 0, $i)));
   * array(t('JAN'), t('FEB'), t('MAR'), t('APR'), t('MAY'), t('JUN'), t('JUL'), t('AUG'), t('SEP'), t('OCT'), t('NOV'), t('DEC'));
   */
  public function gridByMonth($nodes = array(), $field_name = NULL) {
    for ($i = 1; $i < 13; $i++) {
      $month_label[] = t(date('M', mktime(0, 0, 0, $i)));
      $month_nodes = \Drupal::getContainer()->get('flexinfo.querynode.service')->queryNodesByFieldByMonth($nodes, $field_name, array($i));
      $month_data[]  = \Drupal::getContainer()->get('flexinfo.calc.service')->getSumFromNodes($month_nodes, $count_field = NULL);
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
  public function blockChartLineForNodeByMonth($entity_type = NULL, $field_name = NULL) {
    $DashpageJsonGenerator = new DashpageJsonGenerator();

    $query_container = \Drupal::getContainer()->get('flexinfo.querynode.service');
    $nids = $query_container->nidsByBundle($entity_type);
    $nodes = \Drupal::entityManager()->getStorage('node')->loadMultiple($nids);

    // month
    $month_grid = $this->gridByMonth($nodes, $field_name);
    $month_tab = \Drupal::getContainer()->get('flexinfo.chart.service')->renderChartLineDataSet($month_grid['data'], $month_grid['label']);

    $block_title = t('Number of ') . ucwords($entity_type);
    $output = $DashpageJsonGenerator->getBlockOne(
      array(
        'top'  => array(
          'value' => $block_title,          // block top title value
        ),
        'class' => "col-md-12",
      ),
      $DashpageJsonGenerator->getChartLine(
        array(
          "chartOptions" => array('yAxisLabel' => $block_title),
        ),
        $month_tab
      )
    );

    return $output;
  }

  /**
   *
   */
  public function blockChartPieReturnStatus() {
    $DashpageJsonGenerator = new DashpageJsonGenerator();

    $returnstatus_trees = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('returnstatus', 0);

    $chart_data = array();
    $legends = '<div class="padding-top-64 margin-left-12 width-pt-100">';

    if (is_array($returnstatus_trees)) {

      foreach ($returnstatus_trees as $key => $term) {
        $query_container = \Drupal::getContainer()->get('flexinfo.querynode.service');
        $query = $query_container->queryNidsByBundle('repair');
        $group = $query_container->groupStandardByFieldValue($query, 'field_repair_returnstatus', $term->tid);
        $query->condition($group);
        $nids = $query_container->runQueryWithGroup($query);

        $chart_data[] = array(
          "value" => count($nids),
          "color" => \Drupal::getContainer()->get('flexinfo.setting.service')->colorPlateThree($key + 3, TRUE),
          "title" => "1(12)",
        );

        $legends .= '<div class="clear-both height-32 text-center">';
          $legends .= '<span class="legend-square bg-' . \Drupal::getContainer()->get('flexinfo.setting.service')->colorPlateThree($key + 3) . '">';
          $legends .= '</span>';
          $legends .= '<span class="float-left legend-text">';
            $legends .= $term->name;
            $legends .= ' (';
            $legends .= count($nids);
            $legends .= ')';
          $legends .= '</span>';
        $legends .= '</div>';
      }

    }
    $legends .= '</div>';

    $output = $DashpageJsonGenerator->getBlockOne(
      array(
        'top'  => array(
          'value' => '维修返回状态',          // block top title value
        ),
        'class' => "col-md-12",
        "middle" => array(
          'middleMiddle' => array(
            'middleMiddleMiddleClass' => "col-md-8",
            'middleMiddleRightClass' => "col-md-4",
            'middleMiddleRight' => $legends,
          ),
        ),
      ),
      $DashpageJsonGenerator->getChartPie(array("chartType" => "Pie"), $chart_data)
    );

    return $output;
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
  public function reportSnapshotObjectContent() {
    $output['contentSection'][] = $this->blockChartPieReturnStatus();
    $output['contentSection'][] = $this->blockChartLineForNodeByMonth($entity_type = 'request', $field_name = 'field_request_checkdate');
    $output['contentSection'][] = $this->blockChartLineForNodeByMonth($entity_type = 'repair', $field_name = 'field_repair_receivedate');
    $output['contentSection'][] = $this->blockChartLineForNodeByMonth($entity_type = 'quote', $field_name = 'field_quote_date');

    return $output;
  }

}
