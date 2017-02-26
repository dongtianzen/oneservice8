<?php

/**
 * @file
 * Contains \Drupal\manageinfo\Controller\ManageinfoController.
 */

namespace Drupal\manageinfo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Component\Utility\Xss;

use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\dashpage\Content\DashpageContentGenerator;
use Drupal\dashpage\Content\DashpageJsonGenerator;

use Drupal\manageinfo\Content\ManageinfoContentGenerator;
use Drupal\manageinfo\Content\ManageinfoJsonGenerator;

use Drupal\terminfo\Controller\TerminfoJsonController;

/**
 * An example controller.
 */
class ManageinfoController extends ControllerBase {

  /**
   * @return Xss::getAdminTagList() + custom tags
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
   * @return php object, not JSON
   */
  public function convertArrayToCommonTable($term_content = array()) {
    $table_value = array();
    if (is_array($term_content)) {
      foreach ($term_content as $row) {
        $tbody_content[] = array_values($row);
      }

      $table_value = array(
        "thead" => array(array_keys($term_content[0])),
        "tbody" => array_values($tbody_content),
      );
    }

    $DashpageJsonGenerator = new DashpageJsonGenerator();
    $output['contentSection'] = array(
      $DashpageJsonGenerator->getBlockOne(
        array('class' => "col-md-12", 'type' => "commonTable"),
        $DashpageJsonGenerator->getCommonTable($option = array(), $table_value)
      ),
    );

    return $output;
  }

  /**
   * {@inheritdoc}
   * use Drupal\dashpage\Content\DashpageContentGenerator;
   */
  public function manageinfoList($topic) {
    // load and use DashpageContent templage
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
   * {@inheritdoc}
   * @return php object, not JSON
   */
  public function termTableContent($topic) {
    $TerminfoJsonController = new TerminfoJsonController();
    $term_content = $TerminfoJsonController->basicCollectionContent($topic);

    $output = $this->convertArrayToCommonTable($term_content);

    return $output;
  }


  /**
   * {@inheritdoc}
   */
  public function settingIndex() {
    $ManageinfoContentGenerator = new ManageinfoContentGenerator();
    $output = $ManageinfoContentGenerator->settingIndex();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => $this->adminTag(),
    );

    return $build;
  }

}
