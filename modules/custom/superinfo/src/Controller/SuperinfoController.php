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
   *
   */
  public function adminTag() {
    $admin_tags = Xss::getAdminTagList();
    $admin_tags_plus = [
      'canvas', 'form', 'input', 'label', 'md-button', 'md-content',
      'md-datepicker', 'md-input-container', 'md-menu', 'md-menu-content',
      'md-option', 'md-select', 'md-slider', 'md-tab', 'md-tabs', 'md-tooltip',
    ];
    $admin_tags = array_merge($admin_tags, $admin_tags_plus);

    return $admin_tags;
  }

  /**
   * {@inheritdoc}
   */
  public function formCreate($entity_type, $bundle) {
    $entity = \Drupal::entityManager()
      ->getStorage($entity_type)
      ->create(
        array('type' => $bundle)    // node_type
      );

    $entity_form = \Drupal::entityTypeManager()
      ->getFormObject($entity_type, 'default')
      ->setEntity($entity);

    $form = \Drupal::formBuilder()->getForm($entity_form);

    return $form;
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

    $SuperinfoContentGenerator = new SuperinfoContentGenerator();
    $output = $SuperinfoContentGenerator->superinfoTable();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => $this->adminTag(),
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

}
