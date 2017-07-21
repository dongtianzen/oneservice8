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
   \Drupal::getContainer()->get('flexinfo.entity.service')->nodeSupplyInsertUpdateTermPartsFieldValue($entity);
   */
  function nodeRepairInsertUpdateSupplyFieldValue($node_entity = NULL) {
    if ($node_entity) {

    }
  }

  /**
   *
   \Drupal::getContainer()->get('flexinfo.entity.service')->nodeSupplyInsertUpdateTermPartsFieldValue($entity);
   */
  function nodeSupplyInsertUpdateTermPartsFieldValue($node_entity = NULL) {
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
   * @param
   *  $entity_type = 'taxonomy_term'
   *  $field_name = 'field_page_city';

   \Drupal::getContainer()->get('flexinfo.field.service')->updateFieldValue('taxonomy_term', $entity, 'field_evaluationform_questionset');
   \Drupal::getContainer()->get('flexinfo.field.service')->updateFieldValue('node', $entity, 'field_page_city');
   */
  function updateFieldValue222($entity_type = 'node', $entity = NULL, $field_name = NULL, $new_field_values = array()) {
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
