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
   * {@inheritdoc}
   */
  public function __call($method, $args) {
    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="row margin-top-16">';
        $output .= 'DashpageContentGenerator __Call not find this method - ' . $method;
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

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

  /**
   *
   */
  public function companyList() {
    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="row margin-top-16">';
        $output .= 'Company List';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function quoteList() {
    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="row margin-top-16">';
        $output .= 'Quote List';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function repairList() {
    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="row margin-top-16">';
        $output .= 'Repair List';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function userList() {
    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="row margin-top-16">';
        $output .= 'User List';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

}
