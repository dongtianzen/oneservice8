<?php

/**
 * @file
 */

namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;
use Drupal\field\Entity\FieldConfig;
use Drupal\views\Views;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\flexinfo\Service\FlexinfoEntityService;

/**
 * An example controller.
 $FlexinfoEntityService = \Drupal::getContainer()->get('flexinfo.entity.service');
 $DashpageContentGenerator = new DashpageContentGenerator($FlexinfoEntityService);
 $DashpageContentGenerator->angularPage();
 */
class DashpageContentGenerator extends ControllerBase {

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('flexinfo.entity.service')
    );
  }

  protected $flexinfoEntityService;

  /**
   * Constructor.
   */
  public function __construct(FlexinfoEntityService $flexinfoEntityService) {
    $this->flexinfoEntityService = $flexinfoEntityService;
  }

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
  public function angularSnapshot() {
    $output = '';
    $output .= '<div id="pageInfoBase" data-ng-app="pageInfoBase" class="custom-pageinfo pageinfo-subpage-common">';
      $output .= '<div data-ng-controller="PageInfoBaseController" class="row margin-0">';

        $output .= '<div class="block-one bg-ffffff margin-top-16">';
          $output .= '<div class="">';

            $output .= '<div class="">';
              $output .= '<div class="float-left">';
                $output .= t('Search') . ' <input data-ng-model="inputFilter.$">';
              $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="margin-top-12">';
              $output .= '<table class="table table-hover table-responsive">';
                $output .= '<thead>';
                  $output .= '<tr>';
                    $output .= '<th data-ng-repeat="(tableHeadKey, tableHeadCell) in pageData[0]">';
                      $output .= "{{ tableHeadKey }}";
                    $output .= '</th>';
                  $output .= '</tr>';
                $output .= '</thead>';

                $output .= '<tbody data-ng-repeat="tableRow in pageData | filter:inputFilter" class="">';
                  $output .= '<tr>';
                    $output .= '<td data-ng-repeat="tableRowCell in tableRow">';
                      $output .= '<span data-ng-bind-html="$sce.trustAsHtml(tableRowCell)">{{ tableRowCell }}</span>';
                    $output .= '</td>';
                  $output .= '</tr>';

                $output .= '</tbody>';
              $output .= '</table>';
            $output .= '</div>';

          $output .= '</div>';
        $output .= '</div>';

      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * render views output
   */
  public function renderViewsContent($views_name = NULL) {
    $output = '';

    $date_start = '2017-01-01';
    $date_end   = '2017-02-01';

    $output .= '<div class="dashpage-daterangepicker-wrapper height-16">';
      $output .= '<div id="dashpage-daterangepicker-tag" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">';
          $output .= '<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>';
          $output .= '<span class="margin-left-6">' . $date_start . ' - ' . $date_end . '</span>';
          $output .= '<b class="caret margin-left-6"></b>';
      $output .= '</div>';
    $output .= '</div>';

    if ($views_name) {
      $view_content = views_embed_view($views_name, 'default');

      $output .= '<div class="dashpage-wrapper margin-top-24 clear-both">';
        $output .= render($view_content);
      $output .= '</div>';
    }

    return $output;
  }

  /**
   * @return, user uid
   */
  public function _entity_load_user($tid) {
    $output = NULL;

    $term = \Drupal::entityTypeManager()->getStorage('user')->load($tid);
    if ($term) {
      $output = $term->get('name')->value;
    }

    return $output;
  }

  /**
   * render views output
   */
  public function repairPrint($nid = NULL) {
    $output = '';

    $output .= '<div class="dashpage-wrapper">';

      $node  = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
      if ($node) {
        $output .= '<table class="table table-bordered table-hover table-responsive">';
          $output .= '<tbody>';
            $output .= '<tr>';
              $output .= '<td>客户名称</td>';
              $output .= '<td colspan="3">' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_clientname') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>联系人</td>';
              $output .= '<td>' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_contactname') . '</td>';
              $output .= '<td>联系电话</td>';
              $output .= '<td>' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_contactphone') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>客户地址</td>';
              $output .= '<td colspan="3"></td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>设备型号</td>';
              $output .= '<td>' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_devicetype') . '</td>';
              $output .= '<td>序列号</td>';
              $output .= '<td>' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_serialnumber') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>收取日期</td>';
              $output .= '<td colspan="3">' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_receivedate') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>收取备注</td>';
              $output .= '<td colspan="3">' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_receivenote') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>故障原因</td>';
              $output .= '<td colspan="3">' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_issuereason') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>维修处理办法</td>';
              $output .= '<td colspan="3">' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_repairapproach') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>返回备注</td>';
              $output .= '<td colspan="3">' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_returnnote') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>收费金额</td>';
              $output .= '<td colspan="3">' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_quoteamount') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>维修工程师</td>';
              $output .= '<td>' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_checkstaff') . '</td>';
              $output .= '<td>返回日期</td>';
              $output .= '<td>' . $this->flexinfoEntityService->getEntity('field')->getFieldSingleValue('node', $node, 'field_repair_returndate') . '</td>';
            $output .= '</tr>';
          $output .= '</tbody>';
        $output .= '</table>';

      }
      else {
        $output .= $this->t('没有发现维修信息');
      }

    $output .= '</div>';

    return $output;
  }

}
