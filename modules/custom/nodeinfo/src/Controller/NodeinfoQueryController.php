<?php
/**
 * @file
 * Contains \Drupal\nodeinfo\Controller\NodeinfoQueryController.

 $NodeinfoQueryController = new NodeinfoQueryController();
 $NodeinfoQueryController->meetingNids();
 */

namespace Drupal\nodeinfo\Controller;

use Drupal\Core\Entity\Query\QueryFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;

/**
 * Controller routines for page example routes.
 */
// class NodeinfoQueryController extends ControllerBase {

//   protected $entity_query;

//   public function __construct(QueryFactory $entity_query) {
//     $this->entity_query = $entity_query;
//   }

//   public static function create(ContainerInterface $container) {
//     return new static(
//       $container->get('entity.query')
//     );
//   }

//   protected function simpleQuery() {
//     $query = $this->entity_query->get('node')
//       ->condition('status', 1);
//     $nids = $query->execute();
//     return array_values($nids);
//   }

//   public function basicQuery() {
//     return [
//       '#title' => 'Published Nodes',
//       'content' => [
//         '#theme' => 'item_list',
//         '#items' => $this->simpleQuery()
//       ]
//     ];
//   }

//   protected function intermediateQuery() {
//     $query = $this->entity_query->get('node')
//       ->condition('status', 1)
//       ->condition('changed', REQUEST_TIME, '<')
//       ->condition('title', 'ipsum lorem', 'CONTAINS')
//       ->condition('field_tags.entity.name', 'test');
//     $nids = $query->execute();
//     return array_values($nids);
//   }

//   public function conditionalQuery() {
//     return [
//       '#title' => 'Published Nodes Called "ipsum lorem" That Have a Tag "test"',
//       'content' => [
//         '#theme' => 'item_list',
//         '#items' => $this->intermediateQuery()
//       ]
//     ];
//   }

//   protected function advancedQuery() {
//     $query = $this->entity_query->get('node')
//       ->condition('status', 1)
//       ->condition('changed', REQUEST_TIME, '<');
//     $group = $query->orConditionGroup()
//       ->condition('title', 'ipsum lorem', 'CONTAINS')
//       ->condition('field_tags.entity.name', 'test');
//     $nids = $query->condition($group)->execute();
//     return array_values($nids);
//   }

//   public function conditionalGroupQuery() {
//     return [
//       '#title' => 'Published Nodes That Are Called "ipsum lorem" Or Have a Tag "test"',
//       'content' => [
//         '#theme' => 'item_list',
//         '#items' => $this->advancedQuery()
//       ]
//     ];
//   }

// }

/**
 * class
   $NodeinfoQueryController = new NodeinfoQueryController();
   $NodeinfoQueryController->meetingNids();

   $node = entity_load('node', $nid);
   $nodes = entity_load_multiple('node', $nids = array());

   // For a single entity (node):
   $node  = \Drupal::entityTypeManager()->getStorage('node')->load($nid);

   // For multiple entities (nodes):
   $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($nids);

   $nodes = entity_view_multiple($nodes);

   $methods = get_class_methods($node);
   dpm($methods);
 *
 */
class NodeinfoQueryController extends ControllerBase {
  protected $entity_query;

  public function __construct() {
    // $this->entity_query = 55;
    $this->entity_query = $this->container->get('entity.query')->get('node');
  }

  public function basicQuery() {
    dpm($this->nidsByBundle());
    return [
      '#title' => 'Published Nodes',
      'content' => [
        '#theme' => 'item_list',
        '#items' => $this->nidsByBundle(),
      ]
    ];
  }

  /**
   * @return array, nids
   */
  public function nidsByBundle($node_bundle = NULL) {
    $query = \Drupal::entityQuery('node');

    $result = $query->execute();

    return $result;
  }

  /**
   * @return array, nids
   */
  public function nidsByBundleCondition($node_bundle = NULL) {
    $query = \Drupal::entityQuery('node');

    $default_langcode_group = $query->andConditionGroup()
     ->condition('user_id', $properties[$default_langcode]['user_id'], '=', $default_langcode)
     ->condition('name', $properties[$default_langcode]['name'], '=', $default_langcode);

    $langcode_group = $query->andConditionGroup()
     ->condition('name', $properties[$langcode]['name'], '=', $langcode)
     ->condition("$this->field_name.value", $field_value, '=', $langcode);

    $result = $query
      ->condition('status', 1)
      ->condition('changed', REQUEST_TIME, '<')
      ->condition('title', 'cat', 'CONTAINS')
      ->condition('field_tags.entity.name', 'cats')
      ->condition('langcode', $default_langcode)
      ->condition($default_langcode_group)
      ->condition($langcode_group)
      ->sort('name', 'ASC', $default_langcode)
      ->execute();

    return $result;
  }
}
