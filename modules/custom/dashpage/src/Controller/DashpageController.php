<?php

/**
 * @file
 * Contains \Drupal\dashpage\Controller\DashpageController.
 */

namespace Drupal\dashpage\Controller;

use Drupal\Core\Controller\ControllerBase;

use Drupal\dashpage\Content\DashpageContentGenerator;

/**
 * An example controller.
 */
class DashpageController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function clientList() {
    $DashpageContentGenerator = new DashpageContentGenerator();
    $output = $DashpageContentGenerator->clientList();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
    );
    return $build;
  }

}
