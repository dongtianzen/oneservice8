<?php

/**
 * @file
 * Contains \Drupal\dashpage\Controller\DashpageController.
 */

namespace Drupal\dashpage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Utility\Xss;

use Drupal\dashpage\Content\DashpageContentGenerator;
use Drupal\dashpage\Content\DashpageJsonGenerator;
use Drupal\manageinfo\Controller\ManageinfoController;

/**
 * An example controller.
 */
class DashpageController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function angularSnapshot() {
    $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');

    $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
    $output = $DashpageContentGenerator->angularSnapshot();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
      '#attached' => array(
        'library' => array(
          'dashpage/angular_snapshot',
        ),
      ),
    );
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function angularTableGeneratorTemplate($topic = NULL) {
    $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');

    $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
    $output = $DashpageContentGenerator->angularSnapshot();

    $ManageinfoController = new ManageinfoController($FlexinfoEntityService);
    $json_content_data = $ManageinfoController->manageinfoTableContent($topic);

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
      '#attached' => array(
        'library' => array(
          'dashpage/angular_snapshot',
        ),
        'drupalSettings' => [
          'manageinfo' => [
            'manageinfoTable' => [
              'jsonContentData' => $json_content_data,
            ],
          ],
        ],
      ),
    );
    return $build;
  }

  /**
   * call from routing.yml
   */
  public function landingPage() {
    // set empty title
    $request = \Drupal::request();
    if ($route = $request->attributes->get(\Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT)) {
      $route->setDefault('_title', ' ');
    }

    $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');

    $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
    $output = $DashpageContentGenerator->landingPage();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
    );
    return $build;
  }

  /**
   * call from routing.yml
   */
  public function quotePrint($nid) {
    $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');

    $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
    $output = $DashpageContentGenerator->quotePrint($nid);

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
    );
    return $build;
  }

  /**
   * call from routing.yml
   */
  public function repairPrint($nid) {
    $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');

    $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
    $output = $DashpageContentGenerator->repairPrint($nid);

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
    );
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function reportSnapshot() {
    $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');

    $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
    $output = $DashpageContentGenerator->angularSnapshot();

    $DashpageJsonGenerator = new DashpageJsonGenerator();
    $json_content_data = $DashpageJsonGenerator->angularJson();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
      '#attached' => array(
        'library' => array(
          'dashpage/angular_snapshot',
        ),
        'drupalSettings' => [
          'dashpage' => [
            'dashpageContent' => [
              'jsonContentData' => $json_content_data,
            ],
          ],
        ],
      ),
    );

    return $build;
  }

  /**
   * call from routing.yml
   */
  public function standardList($section, $entity_id) {
    return $this->angularTableGeneratorTemplate($section);

    return $this->viewsTableGeneratorTemplate('renderViewsContent', 'node_parts_collection');
    return $this->viewsTableGeneratorTemplate('renderViewsContent', 'node_quote_collection');
    return $this->viewsTableGeneratorTemplate('renderViewsContent', 'node_repair_collection');
    return $this->viewsTableGeneratorTemplate('renderViewsContent', 'term_client_collection');
  }

  /**
   * {@inheritdoc}
   */
  public function viewsTableGeneratorTemplate($method = 'template', $views_name = NULL) {
    $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');

    $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
    $output = $DashpageContentGenerator->{$method}($views_name);

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#attached' => array(
        'library' => array(
          'fxt/bootstrap-daterangepicker',
        ),
      ),
    );
    return $build;
  }

}
