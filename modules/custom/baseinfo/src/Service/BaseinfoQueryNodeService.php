<?php

/**
 * @file
 * Contains Drupal\baseinfo\Service\BaseinfoQueryNodeService.php.
 */

namespace Drupal\baseinfo\Service;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Query\QueryFactory;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\flexinfo\Service\FlexinfoQueryNodeService;

/**
 * An example Service container.
   $BasexinfoQueryNodeService = new BaseinfoQueryNodeService();
   $BasexinfoQueryNodeService->runQueryWithGroup();
 *
   \Drupal::getContainer()->get('baseinfo.querynode.service')->basenodesByBundle();
 */
class BaseinfoQueryNodeService extends FlexinfoQueryNodeService {

  /**
   * @return array, nids
   */
  public function basenodesByBundle($node_bundle = NULL) {
    $nids = $this->nidsByBundle($node_bundle);
    dpm($nids);
    return $nids;
  }

}
