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
    $DashpageBlockGenerator = new DashpageBlockGenerator();

    $output = '';
    $output .= '<div id="pageInfoBase" data-ng-app="pageInfoBase" class="pageinfo-subpage-common">';
      $output .= '<div data-ng-controller="PageInfoBaseController" class="row margin-0 margin-top-16" data-ng-cloak>';

        $output .= '<div class="block-one bg-ffffff padding-bottom-20">';
          $output .= '<div class="row margin-0">';
            $output .= $DashpageBlockGenerator->topWidgetsFixed();
          $output .= '</div>';
        $output .= '</div>';

        $output .= '<div id="charts-section" class="block-three row tab-content-block-wrapper">';
          $output .= '<div data-ng-repeat="block in pageData.contentSection">';
            $output .= '<div class="{{block.class}}">';
              $output .= $DashpageBlockGenerator->contentBlockMaster();
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
    $output .= $this->dateRangePickerBar();

    if ($views_name) {
      $view_content = views_embed_view($views_name, 'default');

      $output .= '<div class="dashpage-wrapper margin-top-24 clear-both">';
        $output .= render($view_content);
      $output .= '</div>';
    }

    return $output;
  }

  /**
   * render views output
   */
  public function dateRangePickerBar() {
    $date_start = '2017-01-01';
    $date_end   = '2017-02-01';

    $output = '';
    $output .= '<div class="dashpage-daterangepicker-wrapper height-16">';
      $output .= '<div id="dashpage-daterangepicker-tag" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">';
          $output .= '<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>';
          $output .= '<span class="margin-left-6">' . $date_start . ' - ' . $date_end . '</span>';
          $output .= '<b class="caret margin-left-6"></b>';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * render views output
   */
  public function quotePrint($nid = NULL) {
    $FieldService = $this->flexinfoEntityService->getEntity('field');

    $output = '';

    $output .= '<div class="dashpage-wrapper">';
      $output .= '<div class="">';
        $output .= '产品保修期外维修单';
      $output .= '</div>';
      $output .= '<div class="">';
        $output .= '贵公司送修的设备型号:';
      $output .= '</div>';
      $output .= '<div class="">';
        $output .= '已经超过保修期, 需要更换配件, 维修后仅对该设备配件将提供为期90天的保修服务.';
      $output .= '</div>';
      $output .= '<div class="">';
        $output .= '维修情况如下:';
      $output .= '</div>';


      $node  = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
      if ($node) {
        $output .= '<table class="table table-hover table-responsive">';
          $output .= '<tbody>';
            $output .= '<tr>';
              $output .= '<td>客户名称</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $node, 'field_quote_clientname') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>联系人</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $node, 'field_quote_warrantyday') . '</td>';
              $output .= '<td>联系电话</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $node, 'field_quote_date') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>客户地址</td>';
              $output .= '<td colspan="3"></td>';
            $output .= '</tr>';
          $output .= '</tbody>';
        $output .= '</table>';

      }
      else {
        $output .= $this->t('没有发现维修信息');
      }

    $output .= '</div>';

          $output .= '<div class="">';
            $output .= '因已经超过保修期，需要支付维修费.费用为￥7000.00(人民币柒仟元整元整).维修后该设备相同部件将提供为期90天的保修服务.
    以下是我司有关汇款信息：

    名称： 北京万博信普通讯技术有限公司
    开户行： 工商银行北京八里庄支行
    帐号： 0200003819020117350

    收到维修费后，北京万博信普通讯技术有限公司负责开具发票，并将设备快递回贵公司。
    李靖
    2017-02-10
    Stamp';
          $output .= '</div>';
          $output .= '<div class="btn btn-success quote-node-print-button hidden-print margin-top-48 clear-both" type="button">Print</div>';

    return $output;
  }

  /**
   * render views output
   */
  public function repairPrint($nid = NULL) {
    $FieldService = $this->flexinfoEntityService->getEntity('field');

    $output = '';

    $output .= '<div class="dashpage-wrapper">';

      $node  = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
      if ($node) {
        $output .= '<table class="table table-bordered table-hover table-responsive">';
          $output .= '<tbody>';
            $output .= '<tr>';
              $output .= '<td>客户名称</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_clientname') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>联系人</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_contactname') . '</td>';
              $output .= '<td>联系电话</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_contactphone') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>客户地址</td>';
              $output .= '<td colspan="3"></td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>设备型号</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_devicetype') . '</td>';
              $output .= '<td>序列号</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_serialnumber') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>收取日期</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_receivedate') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>收取备注</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_receivenote') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>设备规格</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_deviceformat') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>故障原因</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_issuereason') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>维修处理办法</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_repairapproach') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>返回备注</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_returnnote') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>收费金额</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_quoteamount') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>维修工程师</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_checkstaff') . '</td>';
              $output .= '<td>返回日期</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $node, 'field_repair_returndate') . '</td>';
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
