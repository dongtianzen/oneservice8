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
use Drupal\dashpage\Content\DashpageObjectContent;
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
  public function angularTableGeneratorTemplate($section = NULL, $entity_id, $start, $end) {
    $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');

    $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
    $output = $DashpageContentGenerator->angularSnapshot();

    $ManageinfoController = new ManageinfoController($FlexinfoEntityService);
    $json_content_data = $ManageinfoController->manageinfoTableContent($section, $entity_id, $start, $end);

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
      '#attached' => array(
        'library' => array(
          'dashpage/angular_snapshot',
          'fxt/bootstrap-daterangepicker',
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
  public function standardPrint($section, $nid) {
    $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');

    // repairPrint, quotePrint
    $method_name = $section . 'Print';

    $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
    $output = $DashpageContentGenerator->{$method_name}($nid);

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
      '#attached' => array(
        'library' => array(
          'dashpage/quote_authorize',
        ),
      ),
    );
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function reportSnapshot($entity_id, $start, $end) {
    $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');

    $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
    $output = $DashpageContentGenerator->angularSnapshot();

    $DashpageJsonGenerator = new DashpageJsonGenerator();
    $json_content_data = $DashpageJsonGenerator->angularJson();

    $DashpageObjectContent = new DashpageObjectContent();

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
   * {@inheritdoc}
   */
  public function getDashpageSnapshot($meeting_nodes, $section, $entity_id) {
    $DashpageObjectContent = new DashpageObjectContent();

    // combine like -- programSnapshotObjectContent
    $content_method = $section . 'SnapshotObjectContent';

    $object_content_data = NULL;
    if (method_exists($DashpageObjectContent, $content_method)) {
      $object_content_data = $DashpageObjectContent->{$content_method}($meeting_nodes, $entity_id);
    }

    return $object_content_data;
  }

  /**
   * call from routing.yml
   */
  public function standardList($section, $entity_id, $start, $end) {
    return $this->angularTableGeneratorTemplate($section, $entity_id, $start, $end);

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
