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
   * @return php object, not JSON
   */
  public function convertArrayToCommonTable($source_array = array()) {
    $table_value = array();
    if (is_array($source_array)) {
      foreach ($source_array as $row) {
        $tbody_content[] = array_values($row);
      }

      $table_thead = array();
      if (is_array($source_array) && isset($source_array[0])) {
        $table_thead = array(array_keys($source_array[0]));
      }

      $table_tbody = array();
      if (isset($tbody_content)) {
        $table_tbody = array_values($tbody_content);
      }

      $table_value = array(
        "thead" => $table_thead,
        "tbody" => $table_tbody,
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

    $json_content_data = $this->manageinfoTableContent($topic);

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
   * {@inheritdoc}
   * @return php object, not JSON
   */
  public function manageinfoTableContent($topic, $entity_id = NULL, $start = NULL, $end = NULL) {
    $flexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');
    $TerminfoJsonController = new TerminfoJsonController($flexinfoEntityService);
    $term_content = $TerminfoJsonController->basicCollectionContent($topic, $entity_id, $start, $end);

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
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
    );

    return $build;
  }

}
