<?php

/**
 * @file
 * Contains \Drupal\dashpage\Controller\ManageinfoController.
 */

namespace Drupal\jsoninfo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Component\Utility\Xss;

use Symfony\Component\HttpFoundation\JsonResponse;

// use Drupal\jsoninfo\Content\ManageinfoContentGenerator;

/**
 * An example controller.
 */
class JsoninfoController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function businessunitSnapshot($nid = NULL) {
    $build = array(
      '#type' => 'markup',
      '#markup' => $this->t('Hello Angular! - ') . $nid,
    );

    return $build;
  }

}
