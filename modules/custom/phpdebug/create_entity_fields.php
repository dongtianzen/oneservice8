<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/create_entity_fields.php');
  _run_batch_entity_create_fields();
 */
use Drupal\field\Entity\FieldStorageConfig;

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
  $fields[] = array(
    'field_name' => 'field_client_contactname',
    'type'       => 'string',
    'label'      => t('Contact Name'),
  );

  // $fields[] = array(
  //   'field_name' => 'field_client_province',
  //   'type'       => 'entity_reference',
  //   'label'      => t('Province'),
  //   'field_storage_config' => array(
  //     'settings' =>  array(
  //       'target_type' => 'taxonomy_term',
  //     ),
  //   ),
  //   'field_config' => array(
  //     'settings' => array(
  //       'handler' => 'default',
  //       'handler_settings' => array(
  //         // Reference a single vocabulary.
  //         'target_bundles' => array(
  //           'province',
  //         ),
  //         // Enable auto-create.
  //         // 'auto_create' => TRUE,
  //       ),
  //     ),
  //   ),
  // );

  return $fields;
}

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
