<?php

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
function _entity_create_node_repair_field() {
  // $fields[] = array(
  //   'field_name' => 'field_repair_client_name',
  //   'type'       => 'entity_reference',
  //   'label'      => t('Client Name'),
  // );
  $fields[] = array(
    'field_name' => 'field_client_contactname',
    'type'       => 'string',
    'label'      => t('Contact Name'),
  );
  $fields[] = array(
    'field_name' => 'field_client_phone',
    'type'       => 'string',
    'label'      => t('Phone'),
  );

  $fields[] = array(
    'field_name' => 'field_client_address',
    'type'       => 'string',
    'label'      => t('Address'),
  );
  // $fields[] = array(
  //   'field_name' => 'field_client_clienttype',
  //   'type'       => 'entity_reference',
  //   'label'      => t('Client Type'),
  // );
  // $fields[] = array(
  //   'field_name' => 'field_client_salesperson',
  //   'type'       => 'entity_reference',
  //   'label'      => t('Salesperson'),
  // );

  return $fields;
}
