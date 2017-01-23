<?php

/**
 * @file
 */

namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;

use Drupal\views\Views;

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
      $output .= '<div class="margin-top-16">';
        $output .= 'DashpageContentGenerator __Call not find this method - ' . $method;
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function clientList() {
    // $view = Views::getView('term_client_collection');

    // $view->setDisplay('default');
    // $view->execute();

// dpm($view->total_rows);
    // $view->getDisplay();

    $output = '';
    $output .= '<divclass="dashpage-wrapper">';
      $output .= '<div class="margin-top-16">';
        $output .= 'Client List';
        // $output .= $view->viewsData;
        // $output .= $view->render();
        // $output .= render($view->render());    // method 1
        // $output .= render($view->buildRenderable('default'));// method 2
        $output .= render(views_embed_view('term_client_collection', 'default'));  // method 3
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
      $output .= '<div class="margin-top-16">';
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
      $output .= '<div class="margin-top-16">';
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
      $output .= '<div class="margin-top-16">';
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
      $output .= '<div class="margin-top-16">';
        $output .= 'User List';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

}
