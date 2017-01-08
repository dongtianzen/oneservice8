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
   *
   */
  public function ContentGeneratorTemplate($method = 'template') {
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
    return $this->ContentGeneratorTemplate('clientList');
  }

  /**
   * call from routing.yml
   */
  public function companyList() {
    return $this->ContentGeneratorTemplate('companyList');
  }

  /**
   * call from routing.yml
   */
  public function quoteList() {
    return $this->ContentGeneratorTemplate('quoteList');
  }

  /**
   * call from routing.yml
   */
  public function repairList() {
    return $this->ContentGeneratorTemplate('repairList');
  }

  /**
   * call from routing.yml
   */
  public function userList() {
    return $this->ContentGeneratorTemplate('userList');
  }

}
