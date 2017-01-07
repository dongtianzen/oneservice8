<?php

/**
 * @file
 */

namespace Drupal\navinfo\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 use Drupal\navinfo\Content\NavinfoBlockGenerator;

 $NavinfoBlockGenerator = new NavinfoBlockGenerator();
 $NavinfoBlockGenerator->contentBlockCharts();
 */
class NavinfoBlockGenerator extends ControllerBase {

  /*
   * Content Block Haeder
   */
  function contentNavigation() {
    $output = '';
    $output .= '<div data-ng-app="navInfoBase" id="App2" data-ng-controller="NavInfoBaseController" class="z-index-900">';
      $output .= '<nav class="navbar navbar-default container">';
        $output .= '<ul class="nav navbar-nav navbar-left">';
          $output .= '<li class="dropdown">';
            $output .= '<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="">';
              $output .= '<span class="fa fa-bell" aria-hidden="true">';
                $output .= '<tt class="width-12 font-size-12">';
                  $output .= '<span class="padding-left-5">3</span>';
                $output .= '</tt>';
              $output .= '</span>';
            $output .= '</a>';
          $output .= '</li>';
        $output .= '</ul>';

        $output .= '<div class="navbar-content-filters-wrapper">';
          $output .= $this->contentNavigationFilters();
        $output .= '</div>';
        $output .= '<div class="navbar-useroptions-wrapper">';
          $output .= $this->contentNavigationUserOptions();
        $output .= '</div>';
        $output .= '<div class="statusbar-content-wrapper clear-both">';
          $output .= $this->contentNavigationStatusbar();
        $output .= '</div>';
      $output .= '</nav>';
    $output .= '</div>';
    return $output;
  }

  /**
   * Implements navbar user options
   */
  function contentNavigationUserOptions() {
    $output = '';
    $output .= '<ul class="nav navbar-nav navbar-left">';
      $output .= '<li class="dropdown">';
        $output .= '<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">';
          $output .= '<i class="fa fa-user"></i>';
          $output .= 'fullname';
        $output .= '</a>';
        $output .= '<ul id="menu1" class="dropdown-menu">';
          $output .= '<li><a href="#"><span class="fa fa-pencil"></span>Edit</a></li>';
            $output .= '<li><a href="#"><span class="fa fa-sign-in"></span>Login</a></li>';
        $output .= '</ul>';
      $output .= '</li>';
    $output .= '</ul>';

    return $output;
  }

  /**
   * Implements navbar filters
   */
  function contentNavigationFilters() {
    $output = '';
    $output .= '<div ng-repeat="menu in navInfoJson.navInfoMenus">';
      $output .= '<ul class="nav navbar-nav navbar-right">';
        $output .= '<li class="dropdown">';
          $output .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{menu.title}}';
            $output .= '<span class="padding-right-6">';
              $output .= '<i class="fa fa-angle-down"></i>';
            $output .= '</span>';
          $output .= '</a>';
          $output .= '<ul class="dropdown-menu">';
            $output .= '<li data-ng-model="subMenu" data-ng-value="subMenu.termTid" data-ng-repeat="subMenu in menu.menuValues" data-ng-click="submitValue(subMenu)">';
              $output .= '<a href="">{{subMenu.termName}}</a>';
            $output .= '</li>';
          $output .= '</ul>';
        $output .= '</li>';
      $output .= '</ul>';
    $output .= '</div>';

    return $output;
  }

  /**
   * Implements statusbar content
   */
  function contentNavigationStatusbar() {
    $output = '';
    $output .= '<div class="">';
      $output .= '<span class="pull-left float-left">';
        $output .= '<span class="header-page-title-wrapper margin-left-60 margin-top-12 font-size-15 float-left">page_title</span>';
      $output .= '</span>';

      $output .= '<span class="pull-right last">';
        $output .= '<div id="reportrange-header" class="pull-right margin-top-8 margin-right-48 bg-00a9e0 color-fff line-height-32">';
          $output .= '<span class="font-size-14 padding-12 color-fff padding-left-24">';
            $output .= '<i class="fa fa-calendar padding-right-10"></i>';
          $output .= '</span>';
          $output .= '<span class="naveinfo-date-block">date_start - date_end</span>';
        $output .= '</div>';
      $output .= '</span>';
    $output .= '</div>';

    return $output;
  }

  /*
   * Content Block Haeder
   */
  function contentSideMenu() {
    $output = '';
    $output .= '<div class="clear-both">';
      $output .= 'SideMenu';
      $output .= $this->contentMetisMenu();
    $output .= '</div>';
    return $output;
  }

  /*
   * Content Block Haeder
   */
  function contentMetisMenu() {
    $output = '';
    $output .= '<ul class="metismenu" id="metis-menu">';
    $output .= '
    <li class="active">
      <a class="has-arrow" href="#" aria-expanded="true">
        <span class="sidebar-nav-item-icon fa fa-github fa-lg"></span>
        <span class="sidebar-nav-item">metisMenu</span>
      </a>
      <ul aria-expanded="true">
        <li>
          <a href="' . base_path() .'dashpage/angular/snapshot">
            <span class="sidebar-nav-item-icon fa fa-star"></span> Dashpage
          </a>
        </li>
        <li>
          <a href="' . base_path() .'manageinfo/angular/form/36">
            <span class="sidebar-nav-item-icon fa fa-code-fork"></span> Form
          </a>
        </li>
        <li>
          <a href="https://github.com/onokumus/metisMenu/issues">
            <span class="sidebar-nav-item-icon fa fa-exclamation-triangle"></span> Issues
          </a>
        </li>
      </ul>
    </li>
    <li id="removable">
      <a class="has-arrow" href="#" aria-expanded="false">Menu 0</a>
      <ul aria-expanded="false">
        <li><a href="#">item 0.1</a></li>
        <li><a href="#">item 0.2</a></li>
        <li><a href="http://onokumus.com">onokumus</a></li>
        <li><a href="#">item 0.4</a></li>
      </ul>
    </li>
    <li>
      <a class="has-arrow" href="#" aria-expanded="false">Menu 1</a>
      <ul aria-expanded="false">
        <li><a href="#">item 1.1</a></li>
        <li><a href="#">item 1.2</a></li>
        <li>
          <a class="has-arrow" href="#" aria-expanded="false">Menu 1.3</a>
          <ul aria-expanded="false">
            <li><a href="#">item 1.3.1</a></li>
            <li><a href="#">item 1.3.2</a></li>
            <li><a href="#">item 1.3.3</a></li>
            <li><a href="#">item 1.3.4</a></li>
          </ul>
        </li>
        <li><a href="#">item 1.4</a></li>
        <li>
          <a class="has-arrow" href="#" aria-expanded="false">Menu 1.5</a>
          <ul aria-expanded="false">
            <li><a href="#">item 1.5.1</a></li>
            <li><a href="#">item 1.5.2</a></li>
            <li><a href="#">item 1.5.3</a></li>
            <li><a href="#">item 1.5.4</a></li>
          </ul>
        </li>
      </ul>
    </li>
    <li>
      <a class="has-arrow" href="#" aria-expanded="false">Menu 2</a>
      <ul aria-expanded="false">
        <li><a href="#">item 2.1</a></li>
        <li><a href="#">item 2.2</a></li>
        <li><a href="#">item 2.3</a></li>
        <li><a href="#">item 2.4</a></li>
      </ul>
    </li>';

    $output .= '</ul>';
    return $output;
  }

}
