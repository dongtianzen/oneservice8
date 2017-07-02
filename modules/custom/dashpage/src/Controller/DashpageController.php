<?php

/**
 * @file
 * Contains \Drupal\dashpage\Controller\DashpageController.
 */

namespace Drupal\dashpage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\Component\Utility\Xss;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
  public function getDashpageSnapshot($section, $entity_id) {
    $DashpageObjectContent = new DashpageObjectContent();

    // combine like -- programSnapshotObjectContent
    $content_method = $section . 'SnapshotObjectContent';

    $object_content_data = NULL;
    if (method_exists($DashpageObjectContent, $content_method)) {
      $object_content_data = $DashpageObjectContent->{$content_method}($section, $entity_id);
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

  /**
   * {@inheritdoc}
   */
  public function standardJson($section, $entity_id, $start, $end) {
    $section = strtolower($section);
    $entity_id = strtolower($entity_id);

    if ($section == 'angular') {
      if ($entity_id == 22 && $start == 33 && $end == 44) {
        return new JsonResponse(NULL);
      }
      $DashpageJsonGenerator = new DashpageJsonGenerator();
      return new JsonResponse($DashpageJsonGenerator->angularJson());
    }
    else {
      $this->standardPath($section);
    }

    $object_content_data = $this->getObjectContentData($section, $entity_id, $start, $end);

    return new JsonResponse($object_content_data);

    $build = array(
      '#type' => 'markup',
      '#markup' => json_encode($object_content_data),
    );

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function standardPath($section) {
    $section = strtolower($section);

    if ($section) {
      switch ($section) {
        case 'home':
        case 'report':

        // user
        case 'speakersummary':

        // datatable
        case 'eventstatus':
          break;

        default:
          \Drupal::getContainer()->get('flexinfo.setting.service')->throwExceptionPage(404);
          break;
      }
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   * use Symfony\Component\HttpFoundation\RedirectResponse;
   */
  public function standardMenuItem($section, $entity_id) {
    $start = \Drupal::getContainer()->get('flexinfo.setting.service')->userStartTime();
    $end = \Drupal::getContainer()->get('flexinfo.setting.service')->userEndTime();

    $uri = '/dashpage/' . $section . '/snapshot/' . $entity_id . '/' . $start . '/' . $end;
    $url = Url::fromUserInput($uri)->toString();

    return new RedirectResponse($url);
  }

  /**
   * {@inheritdoc}
   */
  public function standardSnapshot($section, $entity_id, $start, $end) {
    $section = strtolower($section);
    $entity_id = strtolower($entity_id);

    // $name = 'time_two';
    // Timer::start($name);

    $this->standardPath($section);

    $object_content_data = $this->getObjectContentData($section, $entity_id, $start, $end);

    $build = $this->dashpageSnapshotTemplate($object_content_data);

    // if (\Drupal::currentUser()->id() == 1) {
    //   Timer::stop($name);
    //   dpm('time_two ' . Timer::read($name) . 'ms');
    // }

    return $build;
  }

  /**
   * @param $start = 2016-01-01T23:30:00, $end = 2016-12-31T23:30:00
   */
  public function getObjectContentData($section, $entity_id, $start, $end) {
    $object_content_data = $this->getDashpageSnapshot($section, $entity_id);

    return $object_content_data;
  }

  /**
   *
   */
  public function dashpageSnapshotTemplate($object_content_data = array()) {
    \Drupal::getContainer()->get('flexinfo.setting.service')->setPageTitle();

    $DashpageContentGenerator = new DashpageContentGenerator();
    $markup = $DashpageContentGenerator->angularSnapshot();
    // $markup = '<div id="map" class="google-map-wrapper">map new</div>';

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $markup,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
      '#attached' => array(
        'library' => array(
          'dashpage/angular_snapshot',
          'fxt/html2canvas',
        ),
        'drupalSettings' => [
          'dashpage' => [
            'dashpageData' => [
              'objectContentData' => $object_content_data,
            ],
          ],
        ],
      ),
    );

    return $build;
  }

}
