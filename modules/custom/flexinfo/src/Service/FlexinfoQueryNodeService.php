<?php

/**
 * @file
 * Contains Drupal\flexinfo\Service\FlexinfoQueryNodeService.php.
 */
namespace Drupal\flexinfo\Service;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Query\QueryFactory;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\TypedData\Plugin\DataType\Timestamp;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Component\Utility\Timer;
/**
 * An example Service container.
   $FlexinfoQueryNodeService = new FlexinfoQueryNodeService();
   $FlexinfoQueryNodeService->nidsByBundle();
 *
   \Drupal::getContainer()->get('flexinfo.querynode.service')->nidsByBundle();
 */
class FlexinfoQueryNodeService extends ControllerBase {

  protected $entity_query;

  /**
   * {@inheritdoc}
   */
  public function __construct(QueryFactory $entity_query) {
    $this->entity_query = $entity_query;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.query')
    );
  }

  /**
   * @return array, nids
   */
  public function nidsByBundle($node_bundle = NULL) {
    $query = \Drupal::entityQuery('node');

    $query->condition('status', 1);
    $query->condition('type', $node_bundle);

    $result = $query->execute();

    return array_values($result);
  }

  /** - - - - - - execute - - - - - - - - - - - - - - - - - - - - - - - - -  */

  /**
   * @return array, nids
   */
  public function runQueryWithGroup($query = NULL) {
    $result = $query->execute();

    return array_values($result);
  }

  /** - - - - - - query not run execute() - - - - - - - - - - - - - - - - -  */

  /**
   * @return
   */
  public function queryNidsByBundle($node_bundle = NULL) {
    $query = \Drupal::entityQuery('node');

    $query->condition('status', 1);
    $query->condition('type', $node_bundle);

    return $query;
  }

  /** - - - - - - Meeting Group - - - - - - - - - - - - - - - - - - - - - -  */

  public function groupByMeetingDateTime($query = NULL, $start_time = NULL, $end_time = NULL) {
    $group = $query->andConditionGroup()
      ->condition('field_meeting_date', $start_time, '>')
      ->condition('field_meeting_date', $end_time, '<');

    return $group;
  }

  /**
   * @return array,
   */
  public function groupByMeetingProvinceTid($query = NULL, $province_tid = NULL) {
    $group = $query->andConditionGroup()
      ->condition('field_meeting_province', $province_tid);

    return $group;
  }

  /**
   * @return array,
   */
  public function groupByMeetingProvinceName($query = NULL, $province_name = NULL) {
    $group = $query->andConditionGroup()
      ->condition('field_meeting_province.entity.name', $province_name);

    return $group;
  }

  /** - - - - - - other test - - - - - - - - - - - - - - - - - - - - - - -  */
  /**
   * @return array,
   * get each businessunit_tid of program to check in_array()
   */
  public function meetingNodesByBusinessunit($meeting_nodes = array(), $businessunit_tids = array()) {
    // meetingNodesByBusinessunitUsingCheckBusinessunitTid() a little slow to meetingNodesByBusinessunitUsingCheckProgramTid()
    // $output = $this->meetingNodesByBusinessunitUsingCheckBusinessunitTid($meeting_nodes, $businessunit_tids);

    $output = $this->meetingNodesByBusinessunitUsingCheckProgramTid($meeting_nodes, $businessunit_tids);
    return $output;
  }
  /**
   * get each businessunit_tid of program to check in_array()
   */
  public function meetingNodesByBusinessunitUsingCheckBusinessunitTid($meeting_nodes = array(), $businessunit_tids = array()) {
    $output = array();

    if (is_array($meeting_nodes)) {
      foreach($meeting_nodes as $node) {

        $program_tid = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldTargetId($node, 'field_meeting_program');
        if ($program_tid) {

          $program_term  = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($program_tid);
          $businessunit_tid = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldTargetId($program_term, 'field_program_businessunit');
          if ($businessunit_tid) {
            if (in_array($businessunit_tid, $businessunit_tids)) {
              $output[] = $node;
            }
          }
        }
      }
    }

    return $output;
  }
  /**
   * get program tids for businessunit_tids to check in_array()
   */
  public function meetingNodesByBusinessunitUsingCheckProgramTid($meeting_nodes = array(), $businessunit_tids = array()) {
    $all_program_tids = \Drupal::getContainer()->get('flexinfo.vocabulary.service')->getTidsFromTree('program');
    $program_tids_by_businessunits = \Drupal::getContainer()->get('flexinfo.queryterm.service')->programTidsByBusinessunit($all_program_tids, $businessunit_tids);

    $output = $this->meetingNodesByProgram($meeting_nodes, $program_tids_by_businessunits);

    return $output;
  }

  /**
   * get program tids for businessunit_tids to check in_array()
   */
  public function meetingNodesByDeliverabletype($meeting_nodes = array(), $deliverabletype_tids = array()) {
    $output = array();

    if (is_array($meeting_nodes)) {
      foreach($meeting_nodes as $node) {

        $deliverabletype_tid = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldTargetId($node, 'field_meeting_deliverabletype');
        if ($deliverabletype_tid) {
          if (in_array($deliverabletype_tid, $deliverabletype_tids)) {
            $output[] = $node;
          }
        }
      }
    }

    return $output;
  }

  /**
   * @return array,
   *
   * use preg_match() or substr($date_time, 5, 2) get month number from string "2018-01-01T06:00:00"
   * not below way
   * $timestamp = date_format(date_create($date_time, timezone_open('America/Toronto')), "U");
   * $month_num = \Drupal::service('date.formatter')->format($timestamp, 'page_format_month');
   */
  public function meetingNodesByMonth($meeting_nodes = array(), $months = array()) {
    $output = array();

    if (is_array($meeting_nodes)) {
      foreach($meeting_nodes as $node) {

        $date_time = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldValue($node, 'field_meeting_date');
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
   * @return array,
   \Drupal::getContainer()->get('flexinfo.querynode.service')->meetingNodesByProgram($meeting_nodes, $program_tids);
   */
  public function meetingNodesByProgram($meeting_nodes = array(), $program_tids = array()) {
    $output = array();

    if (is_array($meeting_nodes)) {
      foreach($meeting_nodes as $node) {

        $program_tid = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldTargetId($node, 'field_meeting_program');
        if ($program_tid) {
          if (in_array($program_tid, $program_tids)) {
            $output[] = $node;
          }
        }
      }
    }

    return $output;
  }

  /**
   * @return array,
   *
   * use preg_match() or substr($date_time, 5, 2) get month number from string "2018-01-01T06:00:00"
   * not below way
   * $timestamp = date_format(date_create($date_time, timezone_open('America/Toronto')), "U");
   * $month_num = \Drupal::service('date.formatter')->format($timestamp, 'page_format_month');
   */
  public function meetingNodesByProvince($meeting_nodes = array(), $provinces = array()) {
    $output = NULL;

    if (is_array($meeting_nodes)) {
      foreach($meeting_nodes as $node) {

        $province_tid = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldTargetId($node, 'field_meeting_province');
        if ($province_tid) {
          if (in_array($province_tid, $provinces)) {
            $output[] = $node;
          }
        }
      }
    }

    return $output;
  }

  /**
   * Old version
   * @return array,
   */
  public function meetingNidsByTime($meeting_nodes = array(), $start_time = NULL, $end_time = NULL) {
    $output = NULL;

    $name = 'time_one';
    Timer::start($name);
    if ($start_time || $end_time) {
      if (is_array($meeting_nodes)) {

        foreach($meeting_nodes as $node) {

          // 2016-04-25T23:30:00
          $date_time = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldValue('node', $node, 'field_meeting_date');
          $timestamp = date_format(date_create($date_time, timezone_open('America/Toronto')), "U");

          if ($start_time) {
            if ($timestamp > $start_time) {
              if ($end_time) {
                if ($timestamp < $end_time) {
                  $output[] = $node;
                }
              }
              else {
                $output[] = $node;
              }
            }
          }
          else {
            if ($end_time) {
              if ($timestamp < $end_time) {
                $output[] = $node;
              }
            }
          }

        }
      }
    }
    else {
      $output = $meeting_nodes;
    }

    Timer::stop($name);
    dpm(Timer::read($name) . 'ms');

    return $output;
  }

  /**
   * @return array, nids
   */
  // public function nidsByBundleCondition($node_bundle = NULL) {
  //   $query = \Drupal::entityQuery('node');

  //   $default_langcode_group = $query->andConditionGroup()
  //    ->condition('user_id', $properties[$default_langcode]['user_id'], '=', $default_langcode)
  //    ->condition('name', $properties[$default_langcode]['name'], '=', $default_langcode);

  //   $langcode_group = $query->andConditionGroup()
  //    ->condition('name', $properties[$langcode]['name'], '=', $langcode)
  //    ->condition("$this->field_name.value", $field_value, '=', $langcode);

  //   $result = $query
  //     ->condition('status', 1)
  //     ->condition('changed', REQUEST_TIME, '<')
  //     ->condition('title', 'cat', 'CONTAINS')
  //     ->condition('field_tags.entity.name', 'cats')
  //     ->condition('langcode', $default_langcode)
  //     ->condition($default_langcode_group)
  //     ->condition($langcode_group)
  //     ->sort('name', 'ASC', $default_langcode)
  //     ->execute();

  //   return $result;
  // }

}
