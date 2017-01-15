<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/entity_create_fields.php');
  _run_batch_entity_create_fields();
 */

function _run_batch_entity_create_fields() {
  $entity_info = array(
    'entity_type' => 'node',  // 'node', 'taxonomy_term', 'user'
    'bundle' => 'repair',
  );

  $fields = _entity_fields_info();
  foreach ($fields as $field) {
    _entity_create_fields_save($entity_info, $field);
  }
}

/**
 *
  field type list:
  boolean
  datetime
  decimal
  email
  entity_reference
  file
  float
  image
  integer
  link
  list_integer
  list_string
  telephone
  string         // Text (plain)
  string_long    // Text (plain, long)
  text_long      // Text (formatted, long)
  text_with_summary
 */
function _entity_fields_info() {
  // $fields[] = array(
  //   'field_name' => 'field_repair_client_name',
  //   'type'       => 'entity_reference',
  //   'label'      => t('客户名称'),
  // );
  $fields[] = array(
    'field_name' => 'field_repair_clientsubname',
    'type'       => 'string',
    'label'      => t('Client Sub Name'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_contactname',
    'type'       => 'string',
    'label'      => t('Contact Name'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_contactphone',
    'type'       => 'string',
    'label'      => t('Contact Phone'),
  );

  // 收取
  $fields[] = array(
    'field_name' => 'field_repair_serialnumber',
    'type'       => 'string',
    'label'      => t('Serial Number'),
  );
  // $fields[] = array(
  //   'field_name' => 'field_repair_device_type',
  //   'type'       => 'entity_reference',
  //   'label'      => t('设备类型'),
  // );
  $fields[] = array(
    'field_name' => 'field_repair_deviceformat',
    'type'       => 'string',
    'label'      => t('Device Format'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_receivenote',
    'type'       => 'string',
    'label'      => t('Receive Note'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_receivedate',
    'type'       => 'datetime',
    'label'      => t('Receive Date'),
  );

  // 初验
  $fields[] = array(
    'field_name' => 'field_repair_checknote',
    'type'       => 'string',
    'label'      => t('Check Note'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_checkissue',
    'type'       => 'string',
    'label'      => t('Check Issue'),
  );
  // $fields[] = array(
  //   'field_name' => 'field_repair_check_staff',
  //   'type'       => 'entity_reference',
  //   'label'      => t('初验人员'),
  // );
  $fields[] = array(
    'field_name' => 'field_repair_checkdate',
    'type'       => 'datetime',
    'label'      => t('Check Date'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_quoteamount',
    'type'       => 'decimal',
    'label'      => t('Quote Amount'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_quotestatus',
    'type'       => 'boolean',
    'label'      => t('Quote Status'),
  );

  // 维修
  $fields[] = array(
    'field_name' => 'field_repair_issuereason',
    'type'       => 'string',
    'label'      => t('Issue Reason'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_repairapproach',
    'type'       => 'string',
    'label'      => t('Repair Approach'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_repairamount',
    'type'       => 'decimal',
    'label'      => t('Quote Amount'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_repairdate',
    'type'       => 'string',
    'label'      => t('Repair Date'),
  );

  // 返回
  $fields[] = array(
    'field_name' => 'field_repair_returnamount',
    'type'       => 'decimal',
    'label'      => t('Return Amount'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_returnnote',
    'type'       => 'string',
    'label'      => t('return note'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_returndate',
    'type'       => 'datetime',
    'label'      => t('return date'),
  );
  $fields[] = array(
    'field_name' => 'field_repair_warrantyday',
    'type'       => 'integer',
    'label'      => t('warranty day'),
  );

  return $fields;
}

use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
function _entity_create_fields_save($entity_info, $field) {
  $field_storage = FieldStorageConfig::create(array(
    'field_name'  => $field['field_name'],
    'entity_type' => $entity_info['entity_type'],
    'type'  => $field['type'],
    'settings' => array(
      'target_type' => 'node',
    ),
  ));
  $field_storage->save();

  $field_config = FieldConfig::create([
    'field_name'  => $field['field_name'],
    'label'       => $field['label'],
    'entity_type' => $entity_info['entity_type'],
    'bundle'      => $entity_info['bundle'],
  ]);
  $field_config->save();

  entity_get_form_display($entity_info['entity_type'], $entity_info['bundle'], 'default')
    ->setComponent($field['field_name'], [
      'settings' => [
        'display' => TRUE,
      ],
    ])
    ->save();

  entity_get_display($entity_info['entity_type'], $entity_info['bundle'], 'default')
    ->setComponent($field['field_name'], [
      'settings' => [
        'display_summary' => TRUE,
      ],
    ])
    ->save();
}

/**
 *
 */
function _entity_create_field_template() {
  entity_create('field_storage_config', array(
    'field_name'  => 'field_page_large_text',
    'entity_type' => 'node',                 // 'taxonomy_term'
    'type'        => 'text_with_summary',    // 'entity_reference', 'image'
  ))->save();

  entity_create('field_config', array(
    'field_name'  => 'field_page_large_text',
    'label'       => 'Large Text',
    'entity_type' => 'node',                 // 'taxonomy_term'
    'bundle'      => 'page',
    // optional
    'required'    => FALSE,
    'description' => t('your description'),
  ))->save();

  entity_get_form_display('node', 'page', 'default')
    ->setComponent('field_page_large_text', [
      'settings' => [
        'display' => TRUE,
      ],
    ])
    ->save();

  entity_get_display('node', 'page', 'default')
    ->setComponent('field_page_large_text', [
      'label' => 'above',
      'weight' => 20,
      'settings' => [
        'display_summary' => TRUE,
      ],
      'type' => 'string',
    ])
    ->save();
}

/**
 * Use entity_create('field_entity', $definition)->save().
 */
function _entity_create_fields($entity_info, $field) {
  entity_create('field_storage_config', array(
    'field_name'  => $field['field_name'],
    'entity_type' => $entity_info['entity_type'],
    'type'  => $field['type'],
  ))->save();

  entity_create('field_config', array(
    'field_name'  => $field['field_name'],
    'label'       => $field['label'],
    'entity_type' => $entity_info['entity_type'],
    'bundle'      => $entity_info['bundle'],
    // optional
    // 'required'    => isset($field['required']) ? TRUE : FALSE,
    // 'description' => isset($field['description']) ? $field['description'] : NULL,
  ))->save();

  entity_get_form_display($entity_info['entity_type'], $entity_info['bundle'], 'default')
    ->setComponent($field['field_name'], [
      'settings' => [
        'display' => TRUE,
      ],
    ])
    ->save();

  entity_get_display($entity_info['entity_type'], $entity_info['bundle'], 'default')
    ->setComponent($field['field_name'], [
      'settings' => [
        'display_summary' => TRUE,
      ],
    ])
    ->save();
}
