<?php

/**
 * @file
 * Contains Drupal\nodeinfo\Service\NodeinfoEntityService.php.
 */
namespace Drupal\nodeinfo\Service;

/**
 *
 */
class NodeinfoEntityService {

  /**
   *
   \Drupal::getContainer()->get('nodeinfo.entity.service')->nodeRepairInsertToCreateSupply($entity);
   */
  public function nodeRepairInsertToCreateSupply($node_entity = NULL) {
    if ($node_entity) {
      $parts_values = $node_entity->get('field_repair_partsnum')->getValue();

      if ($parts_values && is_array($parts_values)) {

        foreach ($parts_values as $parts_value) {

          if (isset($parts_value['parts_tid']) && $parts_value['parts_tid']) {
            $field_array = $this->generateSupplyfieldsValueForRepairInsert($node_entity, $parts_value);
            \Drupal::getContainer()->get('flexinfo.node.service')->entityCreateNode($field_array);
          }
        }
      }
    }
  }

  /**
   *
   */
  public function nodeRepairUpdateToUpdateSupply($node_entity = NULL) {
    if ($node_entity) {
      $parts_values = $node_entity->get('field_repair_partsnum')->getValue();

      if ($parts_values && is_array($parts_values)) {

        foreach ($parts_values as $parts_value) {

          if (isset($parts_value['parts_tid']) && $parts_value['parts_tid']) {
            $query_container = \Drupal::getContainer()->get('flexinfo.querynode.service');
            $query = $query_container->queryNidsByBundle('supply');

            $group = $query_container->groupStandardByFieldValue($query, 'field_supply_repairnode', $node_entity->id());
            $query->condition($group);

            $group = $query_container->groupStandardByFieldValue($query, 'field_supply_part', $parts_value['parts_tid']);
            $query->condition($group);

            $nids = $query_container->runQueryWithGroup($query);

            if ($nids) {
              $nid = reset($nids);
              $supply_entity = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
              \Drupal::getContainer()->get('flexinfo.field.service')->updateFieldValue('node', $supply_entity, 'field_supply_number', $parts_value['parts_num']);
            }
          }
        }
      }
    }
  }

  /**
   *
   */
  public function generateSupplyfieldsValueForRepairInsert($node_entity, $parts_value) {
    $entity_bundle = 'supply';
    $language = \Drupal::languageManager()->getCurrentLanguage()->getId();

    $fields_value = array(
      'type' => $entity_bundle,
      'title' => 'Entity ' . $entity_bundle . ' created from repair',
      'langcode' => $language,
      'uid' => 1,
      'status' => 1,
    );

    $fields_value['field_supply_part'] = array($parts_value['parts_tid']);
    $fields_value['field_supply_number'] = array($parts_value['parts_num']);
    $fields_value['field_supply_repairnode'] = array($node_entity->id());

    return $fields_value;
  }

  /**
   *
   \Drupal::getContainer()->get('nodeinfo.entity.service')->nodeSupplyInsertToUpdateTermPartsFieldValue($entity);
   */
  public function nodeSupplyInsertToUpdateTermPartsFieldValue($node_entity = NULL) {
    if ($node_entity) {

      $term_part_tid = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetId($node_entity, 'field_supply_part');
      $new_number = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($node_entity, 'field_supply_number');

      if ($term_part_tid && $new_number) {
        $term_entity = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($term_part_tid);
        $old_number = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($term_entity, 'field_parts_inventory');

        $result_number = $old_number + $new_number;

        if ($term_entity) {
          \Drupal::getContainer()->get('flexinfo.field.service')->updateFieldValue('taxonomy_term', $term_entity, 'field_parts_inventory', $result_number);
        }
      }
    }
  }

  /**
   *
   */
  public function nodeSupplyUpdateToUpdateTermPartsFieldValue($node_entity = NULL) {
    $node_original = \Drupal::entityTypeManager()->getStorage('node')->loadUnchanged($node_entity->id());

    $parts_values = $node_original->get('field_supply_number')->getValue();
    dpm($parts_values);

  }

  /**
   * @param
   *  $entity_type = 'taxonomy_term'
   *  $field_name = 'field_page_city';

   \Drupal::getContainer()->get('flexinfo.field.service')->updateFieldValue('taxonomy_term', $entity, 'field_evaluationform_questionset');
   \Drupal::getContainer()->get('flexinfo.field.service')->updateFieldValue('node', $entity, 'field_page_city');
   */
  public function updateFieldValue222($entity_type = 'node', $entity = NULL, $field_name = NULL, $new_field_values = array()) {
    $field = $entity->get($field_name);
    if ($field->getName() == $field_name) {
      $field->setValue($new_field_values);
      $result = $entity->save();

      if ($result = SAVED_UPDATED) {
        if (\Drupal::currentUser()->id() == 1) {
          dpm('successful update  - ' . $entity->id() . ' - updateFieldValue()');
        }
      }
      else {
        if (\Drupal::currentUser()->id() == 1) {
          dpm('fail to update  - ' . $entity->id() . ' - updateFieldValue()');
        }
      }
    }
  }

}
