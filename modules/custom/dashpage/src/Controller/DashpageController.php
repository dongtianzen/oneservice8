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
   *
   */
  public function adminTag() {
    $admin_tags = Xss::getAdminTagList();
    $admin_tags_plus = [
      'canvas', 'form', 'input', 'label', 'md-button', 'md-content',
      'md-input-container', 'md-menu', 'md-menu-content', 'md-option',
      'md-select', 'md-tab', 'md-tabs', 'md-tooltip',
    ];
    $admin_tags = array_merge($admin_tags, $admin_tags_plus);

    return $admin_tags;
  }

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
      '#allowed_tags' => $this->adminTag(),
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
          'fxt/daterangepicker',
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

    $json_content_data = $this->termTableContent($topic);

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => $this->adminTag(),
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
  public function clientList() {
    return $this->viewsTableGeneratorTemplate('renderViewsContent', 'term_client_collection');
  }

  /**
   * call from routing.yml
   */
  public function partsList() {
    return $this->viewsTableGeneratorTemplate('renderViewsContent', 'node_parts_collection');
  }

  /**
   * call from routing.yml
   */
  public function quoteList() {
    return $this->viewsTableGeneratorTemplate('renderViewsContent', 'node_quote_collection');
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
      '#allowed_tags' => $this->adminTag(),
    );
    return $build;
  }

  /**
   * call from routing.yml
   */
  public function repairList() {
    return $this->viewsTableGeneratorTemplate('renderViewsContent', 'node_repair_collection');
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
      '#allowed_tags' => $this->adminTag(),
    );
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function reportSnapshot() {
    // load and use DashpageContent templage
    $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');

    $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
    $output = $DashpageContentGenerator->angularSnapshot();

    $ManageinfoController = new ManageinfoController($FlexinfoEntityService);
    $json_content_data = $ManageinfoController->termTableContent('company');

    $DashpageJsonGenerator = new DashpageJsonGenerator();
    $json_content_data = $DashpageJsonGenerator->angularJson();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => $this->adminTag(),
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

}
