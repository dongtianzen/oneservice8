<?php

/**
 * @file
 */

namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 $DashpageContentGenerator = new DashpageContentGenerator();
 $DashpageContentGenerator->angularPage();
 */
class DashpageContentGenerator extends ControllerBase {

  /**
   *
   */
  public function clientList() {
    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="row margin-top-16">';
        $output .= 'Client List';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

}
