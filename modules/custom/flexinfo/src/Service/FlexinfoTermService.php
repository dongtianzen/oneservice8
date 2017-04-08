<?php

/**
 * @file
 * Contains Drupal\flexinfo\Service\FlexinfoTermService.php.
 */
namespace Drupal\flexinfo\Service;

/**
 * An example Service container.
 $FlexinfoTermService = new FlexinfoTermService();
 $FlexinfoTermService->getNameByTid();
 \Drupal::getContainer()->get('flexinfo.term.service')->getNameByTid($target_id);
 */
class FlexinfoTermService {

  /**
   * @return array, terms entity
   \Drupal::getContainer()->get('flexinfo.term.service')->getFullTermsFromVidName($vid);
   */
  public function getFullTermsFromVidName($vid = NULL) {
    $tids = $this->getTidsFromVidName($vid);
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadMultiple($tids);

    return $terms;
  }

  /**
   * @return term name
   \Drupal::getContainer()->get('flexinfo.term.service')->getNameByTid($target_id);
   */
  public function getNameByTid($tid = NULL) {
    $output = NULL;

    if ($tid) {
      $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($tid);
      if ($term) {
        $output = $term->get('name')->value;
      }
    }

    return $output;
  }

  /**
   * @return array, terms entity
   \Drupal::getContainer()->get('flexinfo.term.service')->getTermsFromTids($tids);
   */
  public function getTermsFromTids($tids = array()) {
    $terms = array();

    if (is_array($tids)) {
      $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadMultiple($tids);
    }

    return $terms;
  }

  /**
   * @return term tid
   \Drupal::getContainer()->get('flexinfo.term.service')->getTidByTermName($term_name);
   */
  public function getTidByTermName($term_name = NULL, $vocabulary = NULL) {
    $output = NULL;

    $terms = taxonomy_term_load_multiple_by_name($term_name, $vocabulary);
    if (count($terms) > 0) {
      $term = reset($terms);

      $output = $term->get('tid')->value;

      if (count($terms) > 1) {
        if (\Drupal::currentUser()->id() == 1) {
          dpm('found this term_name - ' . $term_name . ' in vocabulary more than one - ' . implode(" ", array_keys($terms)) . ' $vocabulary is - ' . $vocabulary);
        }
      }
    }
    else {
      if (\Drupal::currentUser()->id() == 1) {
        dpm('no found this term_name - ' . $term_name . ' - in vocabulary - ' . $vocabulary . ' on getTidByTermName()');
      }
    }

    return $output;
  }

  /**
   * @return array, term tids
   \Drupal::getContainer()->get('flexinfo.term.service')->getTidsFromFullTerms($terms);
   */
  public function getTidsFromFullTerms($terms = array()) {
    $tids = array();

    if (is_array($terms)) {
      foreach ($terms as $term) {
        $tids[] = $term->id();
        // $tids[] = $term->get('tid')->value;
      }
    }

    return $tids;
  }

  /**
   * @return array, term tids
   */
  public function getTidsFromTermTree($term_tree = array()) {
    $tids = array();

    if (is_array($term_tree)) {
      foreach ($term_tree as $term) {
        $tids[] = $term->tid;
      }
    }

    return $tids;
  }

  /**
   * @return array, term tids
   \Drupal::getContainer()->get('flexinfo.term.service')->getTidsFromVidName($vid);
   */
  public function getTidsFromVidName($vid = NULL) {
    $trees = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid, 0);
    $tids = $this->getTidsFromTermTree($trees);

    return $tids;
  }

}
