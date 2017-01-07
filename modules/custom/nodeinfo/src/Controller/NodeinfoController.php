<?php

/**
 * @file
 * Contains \Drupal\nodeinfo\Controller\NodeinfoController.
 */
namespace Drupal\nodeinfo\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 */
class NodeinfoController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function adminSetting() {
    $build = array(
      '#type' => 'markup',
      '#markup' => t('NodeinfoController Content'),
    );
    return $build;
  }
}
