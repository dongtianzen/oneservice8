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
   * @return field single for any type
     \Drupal::getContainer()->get('flexinfo.field.service')->getFieldSingleValue();
   */
  public function getFieldSingleValue($entity_type = NULL, $entity = NULL, $field_name = NULL) {
    $output = '';

    $field = \Drupal\field\Entity\FieldStorageConfig::loadByName($entity_type, $field_name);

    if ($field) {
      $field_standard_type = $this->getFieldStandardType();

      // Standard Type use value directly
      if (in_array($field->getType(), $field_standard_type)) {
        $output = $this->getFieldFirstValue($entity, $field_name);
      }
      elseif ($field->getType() == 'datetime') {
        // $output = $this->getFieldFirstValue($entity, $field_name);    // 2016-02-24T17:00:00
        $output = $this->getFieldFirstValueDateFormat($entity, $field_name);
      }
      elseif ($field->getType() == 'entity_reference') {
        $target_id = $this->getFieldFirstTargetId($entity, $field_name);

        if ($field->getSetting('target_type') == 'taxonomy_term') {
          $output = \Drupal::getContainer()->get('flexinfo.term.service')->getNameByTid($target_id);
        }
        elseif ($field->getSetting('target_type') == 'node') {
          $output = $target_id;
        }
        elseif ($field->getSetting('target_type') == 'user') {
          $output = \Drupal::getContainer()->get('flexinfo.user.service')->getUserNameByUid($target_id);
        }
      }
      else {
        if (\Drupal::currentUser()->id() == 1) {
          dpm('no found this field type - ' . $field->getType());
        }
      }
    }
    else {
      if (\Drupal::currentUser()->id() == 1) {
        dpm('not found field type - for this field - ' . $field_name);
      }
    }

    return $output;
  }

  /**
   * @return array result value together for some entity array
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldAnswerIntArray($entitys, 'field_pool_answerint');
   */
  public function getFieldAnswerIntArray($entity_array = array(), $field_name = NULL) {
    $output = array();

    if (is_array($entity_array)) {
      foreach ($entity_array as $entity) {
        $row = $entity->get($field_name)->getValue();
        if ( is_array($row) && count($row) > 0 ) {
          foreach ($row as $key => $value) {
            if (isset($output[$key])) {
              $output[$key] += $value['value'];
            }
            else {
              $output[$key] = $value['value'];
            }
          }
        }
      }
    }

    return $output;
  }

  /**
   * @return array result value together for some entity array
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldAnswerTermArray();
   */
  public function getFieldAnswerTermArray($entity_array = array(), $field_name = NULL) {
    $output = array();

    if (is_array($entity_array)) {
      foreach ($entity_array as $entity) {
        $output = array_merge($this->getFieldAllValues($entity, $field_name), $output);
      }
    }

    return $output;
  }

  /**
   * @return array result value together for some entity array
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldAnswerIntArray($entitys, 'field_pool_answertext');
   */
  public function getFieldAnswerTextArray($entity_array = array(), $field_name = NULL) {
    $output = array();

    if (is_array($entity_array)) {
      foreach ($entity_array as $entity) {
        $output = array_merge($this->getFieldAllValues($entity, $field_name), $output);
      }
    }

    return $output;
  }

  /**
   * @return field array "target_id"
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldAllTargetIds($entity, $field_name);
   */
  public function getFieldAllTargetIds($entity = NULL, $field_name = NULL) {
    $output = array();

    if ($entity) {
      $field_value_array = $entity->get($field_name)->getValue();
      foreach ($field_value_array as $row) {
        $output[] = $row['target_id'];
      }
    }

    return $output;
  }

  /**
   * @return field array values
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldAllValues();
   */
  public function getFieldAllValues($entity = NULL, $field_name = NULL) {
    $output = array();

    $field_value_array = $entity->get($field_name)->getValue();
    foreach ($field_value_array as $row) {
      $output[] = $row['value'];
    }

    return $output;
  }

  /**
   * @return field single "target_id"
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetId();
   */
  public function getFieldFirstTargetId($entity = NULL, $field_name = NULL) {
    $output = NULL;
    if ($entity) {
      $output = $entity->get($field_name)->target_id;
    }
    return $output;
  }

  /**
   * @return array result value together for some entity array
   */
  public function getFieldFirstTargetIdCollection($entity_array = array(), $field_name = NULL) {
    $output = array();

    if (is_array($entity_array)) {
      foreach ($entity_array as $entity) {
        $output[] = $this->getFieldFirstTargetId($entity, $field_name);
      }
    }

    return $output;
  }

  /**
   * @return field single "target_id"
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetIdTermEntity($entity);
   */
  public function getFieldFirstTargetIdTermEntity($entity = NULL, $field_name = NULL) {
    $term = NULL;

    $target_id = $this->getFieldFirstTargetId($entity, $field_name);
    if ($target_id) {
      $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($target_id);
    }

    return $term;
  }

  /**
   * @return field single "target_id"
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetIdTermName($entity);
   */
  public function getFieldFirstTargetIdTermName($entity = NULL, $field_name = NULL) {
    $target_id = $this->getFieldFirstTargetId($entity, $field_name);
    $output = \Drupal::getContainer()->get('flexinfo.term.service')->getNameByTid($target_id);

    return $output;
  }

  /**
   * @return field single "target_id"
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetIdUserEntity($entity);
   */
  public function getFieldFirstTargetIdUserEntity($entity = NULL, $field_name = NULL) {
    $user = NULL;

    $target_id = $this->getFieldFirstTargetId($entity, $field_name);
    if ($target_id) {
      $user = \Drupal::entityTypeManager()->getStorage('user')->load($target_id);
    }

    return $user;
  }

  /**
   * @return field single "target_id"
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetId();
   */
  public function getFieldFirstTargetIdUserName($entity = NULL, $field_name = NULL) {
    $target_id = $this->getFieldFirstTargetId($entity, $field_name);
    $output = \Drupal::getContainer()->get('flexinfo.user.service')->getUserNameByUid($target_id);

    return $output;
  }

  /**
   * @return field single value
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue();
   */
  public function getFieldFirstValue($entity = NULL, $field_name = NULL) {
    $output = NULL;
    if ($entity) {
      $output = $entity->get($field_name)->value;
    }
    return $output;
  }

  /**
   * @return field single value
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue();
   */
  public function getFieldFirstValueDateFormat($entity = NULL, $field_name = NULL, $type = 'html_date') {
    $timestamp = $this->getFieldFirstValueDateTimestamp($entity, $field_name);

    $output = \Drupal::getContainer()->get('flexinfo.setting.service')->convertTimeStampToHtmlDate($timestamp);

    return $output;
  }

  /**
   * @return array result value together for some entity array
   */
  public function getFieldFirstValueCollection($entity_array = array(), $field_name = NULL) {
    $output = array();

    if (is_array($entity_array)) {
      foreach ($entity_array as $entity) {
        $output[] = $this->getFieldFirstValue($entity, $field_name);
      }
    }

    return $output;
  }

  /**
   * @return field single value
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValueDateTimestamp();
   */
  public function getFieldFirstValueDateTimestamp($entity = NULL, $field_name = NULL) {
    $field_value = $this->getFieldFirstValue($entity, $field_name);

    $timestamp = date_format(date_create($field_value, timezone_open('America/Toronto')), "U");

    return $timestamp;
  }

  /**
   $entity->get($field_name)->getValue()
   * @return basic original array
      Array(
        [0] => Array(
          [value] => 2018-01-01T06:00:00
        )
        [1] => Array(
          [value] => 2017-01-01T06:00:00
        )
      )
   */
  /**
   * @return field standard_type
     \Drupal::getContainer()->get('flexinfo.field.service')->getFieldStandardType();

   * other
   * 'datetime'
   * \Drupal::service('date.formatter')->format($row_value, 'page_daytime', $format = '', $timezone = 'Europe/London')
   *
   * 'entity_reference'
   * 'target_type' == 'taxonomy_term'
   * 'target_type' or 'user'
   */
  public function getFieldStandardType() {
    $field_standard_type = array(
      'boolean',
      // 'datetime',  // covert timestamp to "2017-07-09T16:15:30"
      'decimal',
      'email',
      'list_string',
      'list_integer',
      'integer',
      'string',
      'string_long',
      'text_long',
    );

    return $field_standard_type;
  }

  /**
   * @param $bundle is Vid - Vocabulary Name
   * @return array, only include custom field
   \Drupal::getContainer()->get('flexinfo.field.service')->getFieldsCollectionByEntityBundle();
   */
  public function getFieldsCollectionByEntityBundle($entity_type = NULL, $bundle = NULL) {
    $output = array();

    $field_definitions = \Drupal::service('entity_field.manager')->getFieldDefinitions($entity_type, $bundle);
    // class BaseFieldDefinition
    // https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Field%21BaseFieldDefinition.php/class/BaseFieldDefinition/8.2.x

    foreach ($field_definitions as $field_name => $field_definition) {
      // two approach to check is base field or custom field
      // if (!empty($field_definition->getTargetBundle())) {
      if($field_definition->getFieldStorageDefinition()->isBaseField() === FALSE) {
        $output[$field_name] = $field_definition;
      }
    }

    return $output;
  }

  /**
   * Entity reference
   * @param $bundle, user bundle is 'user'
   * @return vocabulary_name vid
   */
  public function getReferenceVidByFieldName($field_name = NULL, $bundle = NULL, $entity_type = 'taxonomy_term') {
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

  /** - - - - - - Update - - - - - - - - - - - - - - - - - - - - - - - - - -  */
  /**
   * @param
   *  $entity_type = 'taxonomy_term'
   *  $field_name = 'field_page_city';

   \Drupal::getContainer()->get('flexinfo.field.service')->updateFieldValue('taxonomy_term', 2884, 'field_evaluationform_questionset');
   \Drupal::getContainer()->get('flexinfo.field.service')->updateFieldValue('node', 3, 'field_page_city');
   */
  function updateFieldValue($entity_type = 'node', $entity = NULL, $field_name = NULL, $new_field_values = array()) {
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
