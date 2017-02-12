<?php

/**
 *
  from mildder8 run on lillyglobal
  require_once('/Applications/AMPPS/www/mildder8/modules/custom/phpdebug/export_from_d7/export_d7_term.php');
  _taxonomyGetTreeTidNames();
 */

_taxonomyGetTreeTidNames();
function _taxonomyGetTreeTidNames($vid = NULL) {
  $output = array();


  $term_method_collections = _term_method_collections($vid);
  if ($vid) {
    $method_name = '_term_method_collections' . '_' . $vid;

    if (function_exists($method_name)) {
      $term_method_collections = $method_name();
    }
  }

  $vid = $term_method_collections['vid'];
  $field_names = $term_method_collections['field_name'];

  if ($vid) {
    $terms = taxonomy_get_tree($vid);

    if (is_array($terms)) {
      foreach ($terms as $term) {
        $output[$term->tid]['name'] = $term->name;
        $term = taxonomy_term_load($term->tid);

        foreach ($field_names as $field_name => $row) {
          $field_value = NULL;
          $field_info = field_info_field($row['d7_field_name']);

          if ($field_info['type'] == 'entityreference') {
            if ($field_info['settings']['target_type'] == 'user') {
              $user = user_load($term->{$row['d7_field_name']}['und'][0]['target_id']);
              if (isset($user->name)) {
                $field_value = $user->name;
              }
            }
            else {
              if (isset($term->{$row['d7_field_name']}['und'][0]['target_id'])) {
                foreach ($term->{$row['d7_field_name']}['und'] as $value) {
                  $field_term = taxonomy_term_load($value['target_id']);
                  if (isset($field_term->name)) {
                    $field_value[] = $field_term->name;
                  }
                }
              }
            }
          }
          else {       // text, date field
            if (isset($term->{$row['d7_field_name']}['und'][0]['value'])) {
              $field_value = $term->{$row['d7_field_name']}['und'][0]['value'];
            }
          }

          $output[$term->tid]['field'][$row['d8_field_name']] = $field_value;
        }
      }
    }
  }

  $json_data = json_encode($output, JSON_UNESCAPED_UNICODE);
  dpm($json_data);

  // $file_name = '/Applications/AMPPS/www/mildder8/modules/custom/phpdebug/import_data/entity_create_term_json.json';

  // if ($json_data) {
  //   $file = file_save_data($json_data, $file_name, FILE_EXISTS_REPLACE);
  // }
  // else {
  //   // put empty content
  //   $file = file_save_data('', 'public://json/' . $file_name, FILE_EXISTS_REPLACE);
  // }

  return $output;
}

function _term_method_collections($vid = NULL) {
  $output['vid'] = $vid;
  $output['field_name'] = array(
  );
  return $output;
}

/**
 * NotificationPrimary
 */
function _term_method_collections_7() {
  $output['vid'] = 7;
  $output['field_name'] = array(
    array(
      'd7_field_name' => 'field_notify_mail_to',
      'd8_field_name' => 'field_notify_mailto',
    ),
    array(
      'd7_field_name' => 'field_notify_mail_title',
      'd8_field_name' => 'field_notify_mailtitle',
    ),
    array(
      'd7_field_name' => 'field_notify_mail_content',
      'd8_field_name' => 'field_notify_mailcontent',
    ),
    array(
      'd7_field_name' => 'field_notify_ahead_time',
      'd8_field_name' => 'field_notify_aheadtime',
    ),
    array(
      'd7_field_name' => 'field_notify_enable_status',
      'd8_field_name' => 'field_notify_enablestatus',
    ),
  );

  return $output;
}
