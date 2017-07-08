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
  public function formAdd($entity_type, $bundle) {
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

    // $node  = \Drupal::entityTypeManager()->getStorage('node')->load(468);
// dpm(array($node));
// dpm($form['field_repair_requestnode']['widget'][0]['target_id']['#default_value']);

    // set default_value
    // $path_parameters = \Drupal::request()->query->all();
    // if ($path_parameters) {
    //   $parameter = reset($path_parameters);
    //   $node  = \Drupal::entityTypeManager()->getStorage('node')->load($parameter);
    //   if ($node) {
    //     $field_name = 'field_repair_' . key($path_parameters);
    //     if (isset($form[$field_name]['widget'])) {
    //       $form['field_repair_requestnode']['widget'][0]['target_id']['#default_value'] = $node;
    //     }
    //   }
    // }
// dpm($form['field_repair_receivenote']['widget'][0]['value']['#default_value']);

    $form['field_repair_receivenote']['widget'][0]['value']['#default_value'] = 'other things';

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
  public function superinfoTable($section, $entity_id) {
    // set page title
    $request = \Drupal::request();
    if ($route = $request->attributes->get(\Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT)) {
      $route->setDefault('_title', ucwords($section) . ' Table');
    }

    $section = strtolower($section);
    $json_path = $this->superinfoTableJsonPath($section);

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
  public function superinfoTableJsonPath($section) {

    $json_path = base_path() . 'viewsjson/node/page/all';
    if ($section) {
      $json_file_url = 'viewsjson/term/' . $section . '/all';

      $url_is_valid = \Drupal::service('path.validator')->isValid($json_file_url);
      if (!$url_is_valid) {
        $json_file_url = 'terminfojson/basiccollection/' . $section;
      }

      $json_path = base_path() . $json_file_url;
      // special
      switch ($section) {
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
