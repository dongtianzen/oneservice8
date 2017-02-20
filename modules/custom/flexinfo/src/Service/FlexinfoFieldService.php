<?php

/**
 * @file
 * Contains Drupal\flexinfo\Service\FlexinfoFieldService.php.
 */
namespace Drupal\flexinfo\Service;

use Drupal\field\Entity\FieldConfig;

/**
 * An example Service container.
  $FlexinfoFieldService = new FlexinfoFieldService();
  $FlexinfoFieldService->getFieldSingleValue();

  \Drupal::getContainer()->get('flexinfo.field.service')->getReferenceVidByFieldName($field_name);
 */
class FlexinfoFieldService {

  /**
   * @return field single value
   */
  public function getFieldSingleValue($entity_type = NULL, $entity = NULL, $field_name = NULL) {
    $output = '';

    $field = \Drupal\field\Entity\FieldStorageConfig::loadByName($entity_type, $field_name);
    $field_standard_type = array(
      'boolean',
      'datetime',
      'decimal',
      'email',
      'list_integer',
      'integer',
      'string',
      'string_long',
      'text_long',
    );

    if (in_array($field->getType(), $field_standard_type)) {
      $output = $entity->get($field_name)->value;
    }
    elseif ($field->getType() == 'entity_reference') {
      $target_id = $entity->get($field_name)->target_id;

      if ($field->getSetting('target_type') == 'taxonomy_term') {
        $output = \Drupal::getContainer()->get('flexinfo.term.service')->getNameByTid($target_id);
      }
      else{
        $output = \Drupal::getContainer()->get('flexinfo.user.service')->getUserNameByUid($target_id);
      }
    }
    else {
      dpm('no found this field type - ' .$field->getType());
    }

    return $output;
  }

  /**
   * Entity reference
   * @param $bundle, user bundle is 'user'
   * @return vocabulary_name vid
   */
  function getReferenceVidByFieldName($field_name = NULL, $bundle = NULL, $entity_type = 'taxonomy_term') {
    $vocabulary_name = NULL;

    if ($field_name && $bundle) {
      $FieldConfig = FieldConfig::loadByName($entity_type, $bundle, $field_name);

      // @return target_bundles array, most of case, only one option
      $target_bundles = $FieldConfig->getSettings()['handler_settings']['target_bundles'];

      if (is_array($target_bundles)) {
        $vocabulary_name = current($target_bundles);
      }
    }
    // dpm('$vocabulary_name - ' . $vocabulary_name);

    return $vocabulary_name;
  }

}
