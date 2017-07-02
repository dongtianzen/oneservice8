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
   * @return array
   */
  public function tableEventStatus($meeting_nodes = array()) {
    $output = array();

    if (is_array($meeting_nodes)) {
      foreach ($meeting_nodes as $node) {
        $program_entity = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetIdTermEntity($node, 'field_meeting_program');

        $internal_url = Url::fromUserInput('/dashpage/meeting/snapshot/' . $node->id());
        $url_options = array(
          'attributes' => array(
            'class' => array(
              'color-fff',
            ),
          ),
        );
        $internal_url->setOptions($url_options);

        $status_button = '<span class="width-96 height-24 color-fff float-left line-height-24 text-center ' .  \Drupal::getContainer()->get('flexinfo.node.service')->getMeetingStatusColor($node) . '">';
          $status_button .= \Drupal::l(
            \Drupal::getContainer()->get('flexinfo.node.service')->getMeetingStatus($node),
            $internal_url
          );
        $status_button .= '</span>';

        $program_text = '';
        $get_program_name = $program_entity->getName();
        if(strlen($get_program_name) > 40) {
          $program_text  = '<span class="table-tooltip width-180">';
          $program_text .= Unicode::substr($program_entity->getName(), 0, 40) . '...';
          $program_text .= '<span class="table-tooltip-text">';
          $program_text .= $program_entity->getName();
          $program_text .= '</span>';
          $program_text .= '</span>';
        }
        else {
          $program_text .= $program_entity->getName();
        }

        $date_text  = '<span class="width-90 float-left">';
          $date_text .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValueDateFormat($node, 'field_meeting_date');
        $date_text .= '</span>';

        $output[] = array(
          // 'REGION' => \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetIdTermName($node, 'field_meeting_eventregion'),
          'DATE' => $date_text,
          'PROGRAM' => $program_text,
          'THERAPEUTIC AREA' => \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetIdTermName($program_entity, 'field_program_theraparea'),
          'PROVINCE' => \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetIdTermName($node, 'field_meeting_province'),
          'CITY' => \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetIdTermName($node, 'field_meeting_city'),
          'REP' => \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetIdUserName($node, 'field_meeting_representative'),
          'STATUS' => $status_button,
        );
      }
    }

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
    $output['contentSection'][] = $this->reportSnapshot();

    return $output;
  }

}
