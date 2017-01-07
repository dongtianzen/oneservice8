<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/demo/debugcode/create_entity_reference_field.php');
  _entity_create_field(3);
  _query_nodes();
 */


function _entity_create_fields() {
  entity_create('field_storage_config', array(
    'field_name' => 'field_page_large_text',
    'entity_type' => 'node',
    'type' => 'text_with_summary',    // 'entity_reference', 'image'
  ))->save();

  entity_create('field_config', array(
    'field_name' => 'field_page_large_text',
    'label' => 'Large Text',
    'entity_type' => 'node',   // 'taxonomy_term'
    'bundle' => 'page',
    // optional
    'required' => FALSE,
    'description' => t('your description'),
  ))->save();
}
