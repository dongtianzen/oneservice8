<?php

/**
 * @file
 * Contains \Drupal\dashpage\Controller\ManageinfoController.
 */

namespace Drupal\manageinfo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Component\Utility\Xss;

use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\manageinfo\Content\ManageinfoContentGenerator;
use Drupal\manageinfo\Content\ManageinfoJsonGenerator;

/**
 * An example controller.
 */
class ManageinfoController extends ControllerBase {

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
  public function angularForm($tid) {
    $ManageinfoContentGenerator = new ManageinfoContentGenerator();
    $output = $ManageinfoContentGenerator->angularForm();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => $this->adminTag(),
      '#attached' => array(
        'library' => array(
          'manageinfo/angular_form',
        ),
      ),
    );

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function angularJson($tid) {
    $ManageinfoJsonGenerator = new ManageinfoJsonGenerator();
    $output = $ManageinfoJsonGenerator->angularJson();

    return new JsonResponse($output);

    $build = array(
      '#type' => 'markup',
      '#markup' => json_encode($output),
    );
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function manageinfoTable($topic) {
    $ManageinfoContentGenerator = new ManageinfoContentGenerator();
    $output = $ManageinfoContentGenerator->manageinfoTable();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => $this->adminTag(),
      '#attached' => array(
        'library' => array(
          'dashpage/angular_table',
        ),
      ),
    );
    return $build;
  }

}
