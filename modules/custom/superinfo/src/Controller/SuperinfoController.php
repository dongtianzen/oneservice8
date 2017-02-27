<?php

/**
 * @file
 * Contains \Drupal\dashpage\Controller\SuperinfoController.
 */

namespace Drupal\superinfo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Component\Utility\Xss;

use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\superinfo\Content\SuperinfoContentGenerator;
use Drupal\terminfo\Controller\TerminfoFetchController;

/**
 * An example controller.
 */
class SuperinfoController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function formCreate($entity_type, $bundle) {
    $request = \Drupal::request();
    if ($route = $request->attributes->get(\Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT)) {
      $route->setDefault('_title', 'New ' . ucfirst($bundle));
    }

    if ($entity_type == 'node') {
      $entity = \Drupal::entityManager()
        ->getStorage($entity_type)
        ->create(
          array('type' => $bundle)    // node_type
        );
    }
    elseif ($entity_type == 'taxonomy_term' || $entity_type == 'term') {
      $entity = \Drupal::entityManager()
        ->getStorage('taxonomy_term')
        ->create(
          array('vid' => $bundle)
        );
    }

    $entity_form = \Drupal::entityTypeManager()
      ->getFormObject($entity_type, 'default')
      ->setEntity($entity);

    $form = \Drupal::formBuilder()->getForm($entity_form);

    $build = array(
      '#type' => 'markup',
      '#markup' => render($form),
      '#attached' => array(
        'library' => array(
          'superinfo/form_create',
        ),
      ),
    );

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function superinfoTable($topic) {
    // set page title
    $request = \Drupal::request();
    if ($route = $request->attributes->get(\Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT)) {
      $route->setDefault('_title', ucwords($topic) . ' Table');
    }

    $topic = strtolower($topic);
    $json_path = $this->superinfoTableJsonPath($topic);

    $SuperinfoContentGenerator = new SuperinfoContentGenerator();
    $output = $SuperinfoContentGenerator->superinfoTable();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
      '#attached' => array(
        'library' => array(
          'superinfo/superinfo_table',
        ),
        'drupalSettings' => [
          'superinfo' => [
            'superinfoTable' => [
              'jsonFileUrl' => $json_path,
            ],
          ],
        ],
      ),
    );

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function superinfoTableJsonPath($topic) {
    $json_path = base_path() . 'viewsjson/node/page/all';
    if ($topic) {
      $json_file_url = 'viewsjson/term/' . $topic . '/all';

      $url_is_valid = \Drupal::service('path.validator')->isValid($json_file_url);
      if (!$url_is_valid) {
        $json_file_url = 'terminfojson/basiccollection/' . $topic;
      }
      $json_path = base_path() . $json_file_url;
      // special
      switch ($topic) {
        case 'page':
          $json_path = base_path() . 'viewsjson/node/page/all';
          break;

        default:
          break;
      }
    }

    return $json_path;
  }

}
