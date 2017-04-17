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

  /** - - - - - - Node Standard Group - - - - - - - - - - - - - - - - - - - - - -  */
  /**
   * @param $field_name like "field_meeting_province", containing
   * @see https://api.drupal.org/api/drupal/core!lib!Drupal!Core!Entity!Query!QueryInterface.php/function/QueryInterface%3A%3Acondition/8.2.x
   */
  public function groupStandardByFieldValue($query = NULL, $field_name = NULL, $field_value = NULL, $operator = NULL, $langcode = NULL) {
    if ($operator == 'IN' || $operator == 'NOT IN') {
      if (is_array($field_value) && count($field_value) == 0) {
        // $field_value cannot be empty array
        $field_value = array(-1);
      }
    }

    $group = $query->andConditionGroup()
      ->condition($field_name, $field_value, $operator);

    return $group;
  }

  /** - - - - - - wrapper - - - - - - - - - - - - - - - - - - - - - - - - - -  */

  /**
   * @param $start_query_date is HTML Date like 2017-03-24
   \Drupal::getContainer()->get('flexinfo.querynode.service')->wrapperNidesByStandardFieldValue();
   */
  public function wrapperNidesByStandardStartEndQueryQate($node_bundle = NULL, $field_name = NULL, $start_query_date = NULL, $end_query_date = NULL) {
    $query = $this->queryNidsByBundle($node_bundle);

    if ($start_query_date) {
      $group = $this->groupStandardByFieldValue($query, $field_name, $start_query_date, '>');
      $query->condition($group);
    }

    if ($end_query_date) {
      $group = $this->groupStandardByFieldValue($query, $field_name, $end_query_date, '<');
      $query->condition($group);
    }

    $nids = $this->runQueryWithGroup($query);

    return $nids;
  }


}
