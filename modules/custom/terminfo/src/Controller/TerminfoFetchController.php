<?php
/**
 * @file
 */
namespace Drupal\terminfo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Query\QueryFactory;

/**
 * class
   $TerminfoFetchController = new TerminfoFetchController();
   $TerminfoFetchController->count();
 *
 */
class TerminfoFetchController extends ControllerBase {

  /**
   * @return array, tids
   */
  public function getVocabularyTree($vid = NULL) {
    $output = NULL;

    if ($vid) {
      $output = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid, 0);
    }

    return $output;
  }

  /**
   * @return array, tids
   */
  public function getVocabularyTreeTidTerms($vid = NULL) {
    $output = NULL;

    $tree = $this->getVocabularyTree($vid);
    if (is_array($tree)) {
      foreach ($tree as $term) {
        $output[$term->tid] = $term->name;
      }
    }

    return $output;
  }

}
