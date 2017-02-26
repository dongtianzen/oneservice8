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
   * @return key name array
   */
  public function basicCollectionContent($vid) {
    switch ($vid) {
      case 'parts':
      case 'quote':
      case 'repair':
        $output = $this->basicCollectionNodeContent($vid);
        break;

      case 'user':
        $output = $this->basicCollectionUserContent($vid);
        break;

      default:
        $output = $this->basicCollectionTermContent($vid);
        break;
    }

    return $output;
  }

  /**
   * @return php array
   */
  public function basicCollectionNodeContent($entity_bundle) {
    $output = array();

    $nodes = \Drupal::getContainer()->get('flexinfo.querynode.service')->nidsByBundle($entity_bundle);
    // $nodes = array_slice($nodes, 0, 5);

    if (is_array($nodes)) {
      foreach ($nodes as $nid) {
        $row = array();

        $edit_path = '/node/' . $nid . '/edit';
        $edit_url = Url::fromUserInput($edit_path);
        $edit_link = \Drupal::l(t('Edit'), $edit_url);

        $collectionContentFields = $this->collectionContentFields($entity_bundle, $nid, $entity_type = 'node');
        if (is_array($collectionContentFields)) {
          $row = array_merge($row, $collectionContentFields);
        }

        // last
        $row["Edit"] = $edit_link;

        $output[] = $row;
      }
    }

    return $output;
  }

  /**
   * @return php array
   */
  public function basicCollectionTermContent($vid) {
    $output = array();

    $TerminfoFetchController = new TerminfoFetchController();
    $trees = $TerminfoFetchController->getVocabularyTreeTidTerms($vid);
    if (is_array($trees)) {
      foreach ($trees as $tid => $term_name) {
        $row = array();

        $edit_path = '/taxonomy/term/' . $tid . '/edit';
        $edit_url = Url::fromUserInput($edit_path);
        $edit_link = \Drupal::l(t('Edit'), $edit_url);

        // first
        $row["Name"] = $term_name;

        $collectionContentFields = $this->collectionContentFields($vid, $tid, $entity_type = 'taxonomy_term');
        if (is_array($collectionContentFields)) {
          $row = array_merge($row, $collectionContentFields);
        }

        // last
        $row["Edit"] = $edit_link;

        $output[] = $row;
      }
    }

    return $output;
  }

  /**
   * @return php array
   */
  public function basicCollectionUserContent($vid) {
    $output = array();

    $users = \Drupal::entityManager()->getStorage('user')->loadMultiple(NULL);
    // $users = entity_load_multiple('user', NULL);

    if (is_array($users)) {
      foreach ($users as $uid => $user) {
        if ($uid > 1) {
          $row = array();

          $edit_path = '/user/' . $uid . '/edit';
          $edit_url = Url::fromUserInput($edit_path);
          $edit_link = \Drupal::l(t('Edit'), $edit_url);

          // first
          $row["Name"] = $user->get('name')->value;

          $collectionContentFields = $this->collectionContentFields($vid, $uid, $entity_type = 'user');
          if (is_array($collectionContentFields)) {
            $row = array_merge($row, $collectionContentFields);
          }

          // last
          $row["Edit"] = $edit_link;

          $output[] = $row;
        }
      }
    }

    return $output;
  }

  /**
   * @return php array
   */
  public function collectionContentFields($vid = NULL, $entity_id = NULL, $entity_type = 'taxonomy_term') {
    $output = NULL;

    $customManageFields = $this->customManageFields($vid);
    if (is_array($customManageFields)) {
      $entity  = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id);

      foreach ($customManageFields as $field_row) {
        $output[$field_row['field_label']] = $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue($entity_type, $entity, $field_row['field_name']);
      }
    }

    return $output;
  }

  /**
   * @return php array
   */
  public function customManageFields($vid = NULL) {
    $output = NULL;

    switch ($vid) {
      // node
      case 'meeting':
        $output = array(
          array(
            'field_label' => 'Program',
            'field_name'  => 'field_meeting_program',
          ),
          array(
            'field_label' => 'Date',
            'field_name'  => 'field_meeting_date',
          ),
          array(
            'field_label' => 'City',
            'field_name'  => 'field_meeting_city',
          ),
          array(
            'field_label' => 'Province',
            'field_name'  => 'field_meeting_province',
          ),
        );
        break;

      case 'program':
        $output = array(
          array(
            'field_label' => 'Business Unit',
            'field_name'  => 'field_program_businessunit',
          ),
          array(
            'field_label' => 'Area',
            'field_name'  => 'field_program_theraparea',
          ),
          // array(
          //   'field_label' => 'Division',
          //   'field_name'  => 'field_program_division',
          // ),
          array(
            'field_label' => 'Region',
            'field_name'  => 'field_program_region',
          ),
        );
        break;

      // user
      case 'user':
        $output = array(
          array(
            'field_label' => 'Region',
            'field_name'  => 'field_user_region',
          ),
          array(
            'field_label' => 'Business Unit',
            'field_name'  => 'field_user_businessunit',
          ),
        );
        break;

      default:
        break;
    }

    return $output;
  }

}
