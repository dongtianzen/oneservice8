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
      $output .= '<div class="col-md-1"></div>';
        $output .= '<div class="col-md-10">';
          $output .= '<div data-ng-controller="PageInfoBaseController" class="row margin-0 angular-snapshot-wrapper" data-ng-cloak>';

            $output .= '<div class="block-one bg-ffffff">';
              $output .= '<div class="row margin-0">';
                $output .= $DashpageBlockGenerator->topWidgetsFixed();
              $output .= '</div>';
            $output .= '</div>';

            $output .= '<div id="charts-section" class="block-three row tab-content-block-wrapper">';
              $output .= '<div data-ng-repeat="block in pageData.contentSection">';
                $output .= '<div class="{{block.class}} padding-0">';
                  $output .= $DashpageBlockGenerator->contentBlockMaster();
                $output .= '</div>';
              $output .= '</div>';
            $output .= '</div>';

          $output .= '</div>';
        $output .= '</div>';
      $output .= '<div class="col-md-1"></div>';;
    $output .= '</div>';

    return $output;
  }

  /**
   * render views output
   */
  public function renderViewsContent($views_name = NULL) {
    $output = '';

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
  public function landingPage($nid = NULL) {
    $contents = array(
      array(
        'icon' => 'fa-download',
        'caption' => '下载“万博维修申请表”',
        'body' => '用户下载“万博维修申请表”',
      ),
      array(
        'icon' => 'fa-file-text-o',
        'caption' => '填写详细信息',
        'body' => '用户需要填写申请表中的详细信息，我司在维修受理后出具的发票及返修设备的返回地址均以此为依据（除特殊注明）； 用户需标注设备的故障现象，以方便我们进行初检；',
      ),
      array(
        'icon' => 'fa-commenting-o',
        'caption' => '申请表确认',
        'body' => '用户以传真、邮件等形式将维修申请表发给我司进行确认（加盖公章或签名）；',
      ),
      array(
        'icon' => 'fa-newspaper-o',
        'caption' => '快递单号填写',
        'body' => '用户将发至我司的快递单号填写在维修申请表的“物流编码”中，以方便我司查询',
      ),
      array(
        'icon' => 'fa-spinner',
        'caption' => '维修周期为15工作日',
        'body' => '我司的处理流程为 接收、初验、维修和返回；通常故障维修周期为15工作日。
         A 接收，我司接收到待修设备后，用户即可在我网站根据序列号查询到该设备的状态；
         B 初验、维修等流程情况与用户填写不符时，我司会按照申请单中的信息与用户联系；
         C 我司会按申请单中的信息发送维修报价表，如无特殊情况，我们的报价仅包含单次国内的运输费用；
         D 用户付款后，我司开始实施维修；
         E 维修结束后，出具设备的维修报告，对设备的延保日期进行贴示；
         F 我司会按照申请单中的地址给用户返还设备',
      ),
      array(
        'icon' => 'fa-envelope-o',
        'caption' => '接收返回产品',
        'body' => '按照申请单中的地址给用户返还设备',
      ),
    );

    $output = '';
    $output .= '<div class="dashpage-wrapper">';
      $output .= '<div class="row">';

        foreach ($contents as $row) {
          $output .= '<div class="col-xs-12 col-sm-6 col-md-4">';
            $output .= '<div class="thumbnail min-height-216">';
              $output .= '<div class="text-center min-height-42 font-size-28">';
                $output .= '<i class="fa fa-6 font-size-28 ' . $row['icon']. '" aria-hidden="true"></i>';
              $output .= '</div>';
              $output .= '<div class="caption">';
                $output .= '<h5>';
                  $output .= $row['caption'];
                $output .= '</h5>';
                $output .= '<p>';
                  $output .= $row['body'];
                $output .= '</p>';
              $output .= '</div>';
            $output .= '</div>';
          $output .= '</div>';
        }

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
        $output .= '';
      $output .= '</div>';
      $output .= '<div class="">';
        $output .= '已经超过保修期, 需要更换配件, 维修后仅对该设备配件将提供为期90天的保修服务.';
      $output .= '</div>';
      $output .= '<div class="">';
        $output .= '维修情况如下:';
      $output .= '</div>';

      $node  = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
      if ($node) {
        $output .= '<table class="table table-hover table-responsive color-449bb5 font-bold">';
          $output .= '<thead>';
            $output .= '<tr>';
              $output .= '<td>#</td>';
              $output .= '<td>型号</td>';
              $output .= '<td>序列号</td>';
              $output .= '<td>价格</td>';
            $output .= '</tr>';
          $output .= '</thead>';
          $output .= '<tbody>';
            $output .= '<tr>';
              $output .= '<td>客户名称</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $node, 'field_quote_clientname') . '</td>';
            $output .= '</tr>';
          $output .= '</tbody>';
        $output .= '</table>';

      }
      else {
        $output .= $this->t('没有发现维修信息');
      }

      $output .= '<div class="">';
        $output .= '因已经超过保修期，需要支付维修费.费用为￥7000.00(人民币柒仟元整元整).维修后该设备相同部件将提供为期90天的保修服务。';
      $output .= '</div>';
      $output .= '<div class="">';
        $output .= '以下是我司有关汇款信息:';
      $output .= '</div>';
      $output .= '<div class="margin-top-12">';
        $output .= '名称: 北京万博信普通讯技术有限公司';
      $output .= '</div>';
      $output .= '<div class="">';
        $output .= '开户行: 工商银行北京八里庄支行';
      $output .= '</div>';
      $output .= '<div class="">';
      $output .= '帐号: 0200003819020117350';
      $output .= '</div>';
      $output .= '<div class="margin-top-12">';
        $output .= '收到维修费后，北京万博信普通讯技术有限公司负责开具发票，并将设备快递回贵公司。';
      $output .= '</div>';
      $output .= '<div class="">';
        $output .= '李靖';
      $output .= '</div>';
      $output .= '<div class="">';
        $output .= $FieldService->getFieldSingleValue('node', $node, 'field_quote_date');
      $output .= '</div>';

      $output .= '<div class="">';
        $output .= '<div class="margin-left-32 margin-top-n-80">';
          $output .= '<img src="' . base_path() . 'modules/custom/dashpage/image/wanboxinpu_quote_stamp.png" width="128px" height="128px" alt="Stamp" title="Stamp">';
        $output .= '</div>';
      $output .= '</div>';

    $output .= '</div>';

    $check_current_user_roles = \Drupal::getContainer()
      ->get('flexinfo.user.service')
      ->checkUserHasSpecificRolesFromUid(array('siteadmin', 'administrator'), \Drupal::currentUser()->id());

    $output .= '<div id="pageInfoBase" data-ng-app="pageInfoBase" class="manageinfo-question-library margin-left-16">';
      $output .= '<div class="wrapper" data-ng-controller="QuotePrintController" ng-cloak>';
        $output .= '<div class="margin-top-48 clear-both hidden-print">';
          $output .= '<div class="btn btn-success quote-node-print-button " type="button">';
            $output .= t('Print');
          $output .= '</div>';

          if ($check_current_user_roles) {
            if ($FieldService->getFieldSingleValue('node', $node, 'field_quote_authorizestamp')) {
              $output .= '<div class="btn btn-warning quote-node-print-button margin-left-24" ng-click="authorizeSubmit(false)" type="button">';
                $output .= t('UnAuthorize');
              $output .= '</div>';
            }
            else {
              $output .= '<div class="btn btn-info quote-node-print-button margin-left-24" ng-click="authorizeSubmit(true)" type="button">';
                $output .= t('Authorize');
              $output .= '</div>';
            }
          }
        $output .= '</div>';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * render views output
   */
  public function repairPrint($nid = NULL) {
    $FieldService = $this->flexinfoEntityService->getEntity('field');

    $repair_node  = \Drupal::entityTypeManager()->getStorage('node')->load($nid);

    $request_nid = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetId($repair_node, 'field_repair_requestnode');
    $request_node  = \Drupal::entityTypeManager()->getStorage('node')->load($request_nid);

    $output = '';

    $output .= '<div class="dashpage-wrapper">';

      if ($repair_node) {
        $output .= '<table class="table table-bordered table-hover table-responsive">';
          $output .= '<tbody>';
            $output .= '<tr>';
              $output .= '<td>客户名称</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $request_node, 'field_request_clientname') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>联系人</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $request_node, 'field_request_contactname') . '</td>';
              $output .= '<td>联系电话</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $request_node, 'field_request_contactphone') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>客户地址</td>';
              $output .= '<td colspan="3"></td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>设备型号</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $repair_node, 'field_repair_devicetype') . '</td>';
              $output .= '<td>序列号</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $repair_node, 'field_repair_serialnumber') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>收取日期</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $repair_node, 'field_repair_receivedate') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>收取备注</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $repair_node, 'field_repair_receivenote') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>设备规格</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $repair_node, 'field_repair_deviceformat') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>故障原因</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $request_node, 'field_request_issuereason') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>维修处理办法</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $repair_node, 'field_repair_repairapproach') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>返回备注</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $repair_node, 'field_repair_returnnote') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>收费金额</td>';
              $output .= '<td colspan="3">' . $FieldService->getFieldSingleValue('node', $request_node, 'field_request_quoteamount') . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
              $output .= '<td>维修工程师</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $request_node, 'field_request_checkstaff') . '</td>';
              $output .= '<td>返回日期</td>';
              $output .= '<td>' . $FieldService->getFieldSingleValue('node', $repair_node, 'field_repair_returndate') . '</td>';
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
