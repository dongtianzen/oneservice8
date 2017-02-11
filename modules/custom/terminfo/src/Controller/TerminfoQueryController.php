<?php
/**
 * @file
 */
namespace Drupal\terminfo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Query\QueryFactory;

/**
 * class
   $TerminfoQueryController = new TerminfoQueryController();
   $TerminfoQueryController->count();

   $nodes = entity_load_multiple('node', $nids = array());
   $nodes = entity_view_multiple($nodes);

   // Get a taxonomy object.
   $vocabulary = entity_load('taxonomy_vocabulary', 'forums');
   $vocabulary->label();
 *
 */
class TerminfoQueryController extends ControllerBase {

  /**
   * @return array, nids
   */
  public function tidsByBundle($term_bundle = NULL) {
    $term_bundle = 1;
    $query = \Drupal::entityQuery('taxonomy_term')
      ->condition('vid', $term_bundle);

    $result = $query->execute();

    return $result;
  }

  /**
   * @return array, tids
   */
  public function tidsByCondition($term_bundle = NULL) {
    $query = \Drupal::entityQuery('taxonomy_term')
      ->condition('tid', $term->id())
      ->condition('vid', $term->bundle())
      ->range(0, 1)
      ->count()
      ->execute();

    return $query;
  }

  /**
   * @return array, tids
   */
  public function tidsByFieldValue($field_name = NULL, $value = NULL) {
    $query = \Drupal::entityQuery('taxonomy_term')
      ->condition($field_name, $value)
      ->execute();

    return $query;
  }

  /**
   * @return array, tids
   */
  public function tidsByFieldTagertIds($field_name = NULL, $target_ids = array()) {
    $query = \Drupal::entityQuery('taxonomy_term')
      ->condition($field_name, $target_ids, 'IN')
      ->execute();

    return $query;
  }

}
