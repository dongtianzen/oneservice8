<?php

/**
 * @file
 * Contains \Drupal\terminfo\Controller\TerminfoJsonController.
 */

namespace Drupal\terminfo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
  $TerminfoJsonController = new TerminfoJsonController();
  $TerminfoJsonController->basicCollection($topic);
 */
class TerminfoJsonController extends ControllerBase {

  /**
   * {@inheritdoc}
   * use Symfony\Component\HttpFoundation\JsonResponse;
   * @param $topic is vid
   * @return JSON
   */
  public function basicCollection($topic) {
    $output = $this->basicCollectionContent($topic);
    return new JsonResponse($output);
  }

  /**
   * {@inheritdoc}
   * use Symfony\Component\HttpFoundation\JsonResponse;
   * @param, $topic is vid
   * @return php array
   */
  public function basicCollectionContent($topic) {
    $output = array();

    $TerminfoFetchController = new TerminfoFetchController();
    $trees = $TerminfoFetchController->getVocabularyTreeTidTerms($topic);
    if (is_array($trees)) {
      foreach ($trees as $tid => $term_name) {
        $edit_path = '/taxonomy/term/' . $tid . '/edit';
        $edit_url = Url::fromUserInput($edit_path);
        $edit_link = \Drupal::l(t('Edit'), $edit_url);

        $output[] = array(
          "Name" => $term_name,
          "Edit" => $edit_link,
        );
      }
    }

    return $output;
  }

}
