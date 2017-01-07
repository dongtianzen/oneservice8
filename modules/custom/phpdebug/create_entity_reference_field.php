<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/demo/debugcode/create_entity_reference_field.php');
  _entity_create_field(3);
  _query_nodes();
 */


function _run_batch_entity_create_fields() {
  $entity_info = array(
    'entity_type' => 'node',  // 'taxonomy_term', 'user'
    'bundle' => 'page',
  );

  $fields = _entity_fields_info();
  foreach ($fields as $field) {
    _entity_create_fields($entity_info, $field);
  }

}

function _entity_fields_info() {
  $fields[] = array(
    'field_name' => 'field_page_large_text',
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
    'label'       => 'Large Text',
    'entity_type' => $entity_info['entity_type'],
    'bundle'      => $entity_info['bundle'],
    // optional
    'required'    => FALSE,
    'description' => t('your description'),
  ))->save();
}

function _entity_create_field_template() {
  entity_create('field_storage_config', array(
    'field_name'  => 'field_page_large_text',
    'entity_type' => 'node',          // 'taxonomy_term'
    'type'        => 'text_with_summary',    // 'entity_reference', 'image'
  ))->save();

  entity_create('field_config', array(
    'field_name'  => 'field_page_large_text',
    'label'       => 'Large Text',
    'entity_type' => 'node',          // 'taxonomy_term'
    'bundle'      => 'page',
    // optional
    'required'    => FALSE,
    'description' => t('your description'),
  ))->save();
}
