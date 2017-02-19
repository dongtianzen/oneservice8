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
   * @return term name
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
   * @return term tid
   */
  public function getTidByTermName($term_name = NULL, $vocabulary = NULL) {
    $output = NULL;

    $terms = taxonomy_term_load_multiple_by_name($term_name, $vocabulary);
    if (count($terms) > 0) {
      $term = reset($terms);

      $output = $term->get('tid')->value;

      if (count($terms) > 1) {
        dpm('found this term_name - ' . $term_name . ' in vocabulary more than one - ' . implode(" ", array_keys($terms)));
      }
    }
    else {
      dpm('no found this term_name - ' . $term_name . ' in vocabulary - ' . $vocabulary);
    }

    return $output;
  }

}
