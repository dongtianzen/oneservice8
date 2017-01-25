<?php

/**
 * @file
 * Contains \Drupal\dashpage\Controller\DashpageController.
 */

namespace Drupal\dashpage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Utility\Xss;

use Drupal\dashpage\Content\DashpageContentGenerator;

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
  public function angularDemo() {
    $DashpageContentGenerator = new DashpageContentGenerator();
    $output = $DashpageContentGenerator->angularDemo();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
      '#allowed_tags' => $this->adminTag(),
      '#attached' => array(
        'library' => array(
          'dashpage/angular_demo',
        ),
      ),
    );
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function angularSnapshot() {
    $DashpageContentGenerator = new DashpageContentGenerator();
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
   *
   */
  public function contentGeneratorTemplate($method = 'template') {
    $DashpageContentGenerator = new DashpageContentGenerator();
    $output = $DashpageContentGenerator->{$method}();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $output,
    );
    return $build;
  }

  /**
   * call from routing.yml
   */
  public function clientList() {
    return $this->contentGeneratorTemplate('clientList');
  }

  /**
   * call from routing.yml
   */
  public function companyList() {
    return $this->contentGeneratorTemplate('companyList');
  }

  /**
   * call from routing.yml
   */
  public function quoteList() {
    return $this->contentGeneratorTemplate('quoteList');
  }

  /**
   * call from routing.yml
   */
  public function repairList() {
    return $this->contentGeneratorTemplate('repairList');
  }

  /**
   * call from routing.yml
   */
  public function userList() {
    return $this->contentGeneratorTemplate('userList');
  }

}
