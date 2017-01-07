<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/create_entity_reference_field.php');
  _run_batch_entity_create_fields();
 */

function _run_batch_entity_create_fields() {
  $entity_info = array(
    'entity_type' => 'taxonomy_term',  // 'node', 'taxonomy_term', 'user'
    'bundle' => 'client',
  );

  $fields = _entity_fields_info();
  foreach ($fields as $field) {
    _entity_create_fields($entity_info, $field);
  }

}

function _entity_fields_info() {
  $fields[] = array(
    // field_storage_config
    'field_name' => 'field_client_contactname',
    'type'        => 'text_long',       // 'entity_reference', 'image', 'text_with_summary',
    // field_config
    'label'       => t('Contact Name'),
  );

  return $fields;
}

function _entity_create_fields($entity_info, $field) {
  entity_create('field_storage_config', array(
    'field_name'  => $field['field_name'],
    'entity_type' => $entity_info['entity_type'],
    'type'        => $field['type'],
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
}

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
}
