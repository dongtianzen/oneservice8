<?php

/**
 * @file
 * Contains \Drupal\terminfo\Controller\TerminfoJsonController.
 */

namespace Drupal\terminfo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\flexinfo\Service\FlexinfoEntityService;

/**
 *
  $TerminfoJsonController = new TerminfoJsonController();
  $TerminfoJsonController->basicCollection($vid);
 */
class TerminfoJsonController extends ControllerBase {

  protected $flexinfoEntityService;

  /**
   * {@inheritdoc}
   */
  public function __construct(FlexinfoEntityService $flexinfoEntityService) {
    $this->flexinfoEntityService = $flexinfoEntityService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('flexinfo.entity.service')
    );
  }

  /**
   * {@inheritdoc}
   * use Symfony\Component\HttpFoundation\JsonResponse;
   * @param $vid is vid
   * @return JSON
   */
  public function basicCollection($vid) {
    $output = $this->basicCollectionContent($vid);
    return new JsonResponse($output);
  }

  /**
   * {@inheritdoc}
   * use Symfony\Component\HttpFoundation\JsonResponse;
   * @param, $vid is vid
   * @return key name array
   */
  public function basicCollectionContent($vid, $entity_id = NULL, $start = NULL, $end = NULL) {
    switch ($vid) {
      case 'quote':
      case 'repair':
      case 'request':
      case 'supply':
        $output = $this->basicCollectionNodeContent($vid, $entity_id, $start, $end);
        break;

      case 'user':
        $output = $this->basicCollectionUserContent($vid);
        break;

      default:
        $output = $this->basicCollectionTermContent($vid);
        break;
    }

    return $output;
  }

  /**
   * @return php array
   */
  public function basicCollectionNodeContent($entity_bundle, $entity_id = NULL, $start = NULL, $end = NULL) {
    $output = array();

    $nids = $this->basicCollectionNids($entity_bundle, $start, $end);

    if (is_array($nids) && $nids) {
      foreach ($nids as $nid) {
        $row = array();

        $edit_path = '/node/' . $nid . '/edit';
        $edit_url = Url::fromUserInput($edit_path);
        $edit_link = \Drupal::l(t('Edit'), $edit_url);

        $collectionContentFields = $this->collectionContentFields($entity_bundle, $nid, $entity_type = 'node');
        if (is_array($collectionContentFields)) {
          $row = array_merge($row, $collectionContentFields);
        }

        // last
        $row["Edit"] = $edit_link;

        $output[] = $row;
      }
    }

    return $output;
  }

  /**
   * @return php array
   */
  public function basicCollectionNids($entity_bundle = NULL, $start = NULL, $end = NULL) {
    $nids = \Drupal::getContainer()->get('flexinfo.querynode.service')->nidsByBundle($entity_bundle);

    $start_boolean = \Drupal::getContainer()->get('flexinfo.setting.service')->isTimestamp($start);
    $end_boolean = \Drupal::getContainer()->get('flexinfo.setting.service')->isTimestamp($end);
    if ($start_boolean && $end_boolean) {
      $start_query_date = \Drupal::getContainer()
        ->get('flexinfo.setting.service')->convertTimeStampToQueryDate($start);

      $end_query_date = \Drupal::getContainer()
        ->get('flexinfo.setting.service')->convertTimeStampToQueryDate($end);

      if ($entity_bundle == 'quote') {
        $nids = \Drupal::getContainer()
          ->get('flexinfo.querynode.service')
          ->wrapperNidesByStandardStartEndQueryQate('quote', 'field_quote_date', $start_query_date, $end_query_date);
      }
      elseif ($entity_bundle == 'repair') {
        $nids = \Drupal::getContainer()
          ->get('flexinfo.querynode.service')
          ->wrapperNidesByStandardStartEndQueryQate('repair', 'field_repair_checkdate', $start_query_date, $end_query_date);
      }
    }

    // $nids = array_slice($nodes, 0, 10);

    return $nids;
  }

  /**
   * @return php array
   */
  public function basicCollectionTermContent($vid) {
    $output = array();

    $TerminfoFetchController = new TerminfoFetchController();
    $trees = $TerminfoFetchController->getVocabularyTreeTidTerms($vid);
    if (is_array($trees)) {
      foreach ($trees as $tid => $term_name) {
        $row = array();

        $edit_path = '/taxonomy/term/' . $tid . '/edit';
        $edit_url = Url::fromUserInput($edit_path);
        $edit_link = \Drupal::l(t('Edit'), $edit_url);

        // first
        $row["Name"] = $term_name;

        $collectionContentFields = $this->collectionContentFields($vid, $tid, $entity_type = 'taxonomy_term');
        if (is_array($collectionContentFields)) {
          $row = array_merge($row, $collectionContentFields);
        }

        // last
        $row["Edit"] = $edit_link;

        $output[] = $row;
      }
    }

    return $output;
  }

  /**
   * @return php array
   */
  public function basicCollectionUserContent($vid) {
    $output = array();

    $users = \Drupal::entityManager()->getStorage('user')->loadMultiple(NULL);
    // $users = entity_load_multiple('user', NULL);

    if (is_array($users)) {
      foreach ($users as $uid => $user) {
        if ($uid > 1) {
          $row = array();

          $edit_path = '/user/' . $uid . '/edit';
          $edit_url = Url::fromUserInput($edit_path);
          $edit_link = \Drupal::l(t('Edit'), $edit_url);

          // first
          $row["Name"] = $user->get('name')->value;

          $collectionContentFields = $this->collectionContentFields($vid, $uid, $entity_type = 'user');
          if (is_array($collectionContentFields)) {
            $row = array_merge($row, $collectionContentFields);
          }

          // last
          $row["Edit"] = $edit_link;

          $output[] = $row;
        }
      }
    }

    return $output;
  }

  /**
   * @return php array
   */
  public function collectionContentFields($vid = NULL, $entity_id = NULL, $entity_type = 'taxonomy_term') {
    $output = NULL;

    $customManageFields = $this->customManageFields($vid);
    if (is_array($customManageFields)) {
      $entity  = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id);

      foreach ($customManageFields as $field_row) {
        if ($field_row['field_name'] == 'custom_formula_function') {
          $output[$field_row['field_label']] = $this->{$field_row['formula_function']}($entity_id);
        }
        else {    // noraml custom field
          $output[$field_row['field_label']] = $this->flexinfoEntityService->getEntity('field')
            ->getFieldSingleValue($entity_type, $entity, $field_row['field_name']);
        }
      }
    }

    return $output;
  }

  /**
   * @return php array
   */
  public function customManageFields($vid = NULL) {
    $output = NULL;

    switch ($vid) {
      // node
      case 'quote':
        $output = array(
          array(
            'field_label' => 'Client Name',
            'field_name'  => 'field_quote_clientname',
          ),
          array(
            'field_label' => 'Sum',
            'field_name'  => 'field_quote_sumprice',
          ),
          array(
            'field_label' => 'Warranty',
            'field_name'  => 'field_quote_warrantyday',
          ),
          array(
            'field_label' => 'Date',
            'field_name'  => 'field_quote_date',
          ),
          array(
            'field_label' => 'Company',
            'field_name'  => 'field_quote_company',
          ),
          array(
            'field_label' => 'Stamp',
            'field_name'  => 'custom_formula_function',
            'formula_function'  => 'stampForQuoteNode',
          ),
          array(
            'field_label' => 'Print',
            'field_name'  => 'custom_formula_function',
            'formula_function'  => 'linkForQuotePrint',
          ),
        );
        break;

      case 'repair':
        $output = array(
          array(
            'field_label' => 'Device',
            'field_name'  => 'field_repair_devicetype',
          ),
          array(
            'field_label' => 'Serial Num',
            'field_name'  => 'field_repair_serialnumber',
          ),
          array(
            'field_label' => 'Receive',
            'field_name'  => 'field_repair_receivedate',
          ),
          array(
            'field_label' => 'Repair',
            'field_name'  => 'field_repair_repairdate',
          ),
          array(
            'field_label' => 'Return',
            'field_name'  => 'field_repair_returndate',
          ),
          array(
            'field_label' => 'Print',
            'field_name'  => 'custom_formula_function',
            'formula_function'  => 'linkForRepairPrint',
          ),
        );
        break;

      case 'request':
        $output = array(
          array(
            'field_label' => 'Date',
            'field_name'  => 'field_request_checkdate',
          ),
          array(
            'field_label' => 'Client Name',
            'field_name'  => 'field_request_clientname',
          ),
          array(
            'field_label' => 'Device',
            'field_name'  => 'field_request_devicetype',
          ),
          array(
            'field_label' => 'Check',
            'field_name'  => 'field_request_checkdate',
          ),
          array(
            'field_label' => 'Add',
            'field_name'  => 'custom_formula_function',
            'formula_function'  => 'linkForAddRepair',
          ),
        );
        break;

      case 'supply':
        $output = array(
          array(
            'field_label' => 'Part',
            'field_name'  => 'field_supply_part',
          ),
          array(
            'field_label' => 'Number',
            'field_name'  => 'field_supply_number',
          ),
        );
        break;

      // term
      case 'client':
        $output = array(
          array(
            'field_label' => 'Address',
            'field_name'  => 'field_client_address',
          ),
          array(
            'field_label' => 'Client Type',
            'field_name'  => 'field_client_clienttype',
          ),
          array(
            'field_label' => 'Contact Name',
            'field_name'  => 'field_client_contactname',
          ),
          array(
            'field_label' => 'EMAIL',
            'field_name'  => 'field_client_email',
          ),
          array(
            'field_label' => 'Phone',
            'field_name'  => 'field_client_phone',
          ),
          array(
            'field_label' => 'PROVINCE',
            'field_name'  => 'field_client_province',
          ),
          array(
            'field_label' => 'SALESPERSON',
            'field_name'  => 'field_client_salesperson',
          ),
        );
        break;

      case 'parts':
        $output = array(
          array(
            'field_label' => 'Type',
            'field_name'  => 'field_parts_devicetype',
          ),
          array(
            'field_label' => 'Inventory',
            'field_name'  => 'field_parts_inventory',
          ),
        );
        break;

      // user
      case 'user':
        $output = array(
          array(
            'field_label' => 'Region',
            'field_name'  => 'field_user_region',
          ),
          array(
            'field_label' => 'Business Unit',
            'field_name'  => 'field_user_businessunit',
          ),
        );
        break;

      default:
        break;
    }

    return $output;
  }

  /** - - - - - - custom - - - - - - - - - - - - - - - - - - - - - - - - -  */

  /**
   * @return
   */
  public function linkForAddRepair($quote_nid = NULL) {
    $link = NULL;
    if ($quote_nid) {
      $path = '/superinfo/form/add/node/repair';
      $url = Url::fromUserInput($path);
      $link = \Drupal::l('Add', $url);
    }

    return $link;
  }
  /**
   * @return
   */
  public function linkForQuotePrint($quote_nid = NULL) {
    $link = NULL;
    if ($quote_nid) {
      $path = '/dashpage/quote/print/' . $quote_nid;
      $url = Url::fromUserInput($path);
      $link = \Drupal::l('Print', $url);
    }

    return $link;
  }
  /**
   * @return
   */
  public function linkForRepairPrint($repair_nid = NULL) {
    $link = NULL;
    if ($repair_nid) {
      $path = '/dashpage/repair/print/' . $repair_nid;
      $url = Url::fromUserInput($path);
      $link = \Drupal::l('Print', $url);
    }

    return $link;
  }

  /**
   * @return
   */
  public function stampForQuoteNode($quote_nid = NULL) {
    $stamp_path = base_path() . drupal_get_path('module', 'dashpage') . '/image/wanboxinpu_quote_stamp.png';

    $output = NULL;
    if ($quote_nid) {
      $node  = \Drupal::entityTypeManager()->getStorage('node')->load($quote_nid);
      $stamp = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($node, 'field_quote_authorizestamp');

      if ($stamp) {
        $output = '<span class="width-20">';
          $output .= '<img src="' . $stamp_path . '" alt="stamp" class="width-20">';
        $output .= '</span>';
      }
    }

    return $output;
  }

}
