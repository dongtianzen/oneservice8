<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/import_data/entity_create_term.php');
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/import_data/entity_create_common_fn.php');
  drupal_set_time_limit(0);
  _run_batch_entity_create_terms();
 */

use Drupal\taxonomy\Entity\Term;
use Drupal\Component\Utility\Timer;

use Drupal\field\Entity\FieldConfig;

use Drupal\Core\Url;

function _run_batch_entity_create_terms() {
  $vocabulary = array(
    'vid'  => 'notification',
  );

  $name = 'time_one';
  Timer::start($name);

  $terms_array = _fetch_convert_json();

  if (is_array($terms_array)) {
    foreach ($terms_array as $key => $row) {
      if (1 < 97) {
        _entity_create_terms($row, $vocabulary);
        dpm(31);
      }
    }
  }

  Timer::stop($name);
  dpm(Timer::read($name) . 'ms');
}

function _entity_create_terms($row = array(), $vocabulary) {
  $term_value = [
    'name' => $row['name'],
    'vid'  => $vocabulary['vid'],
  ];

  if (isset($row['field']) && is_array($row['field'])) {
    foreach ($row['field'] as $field_name => $value) {

      $field = \Drupal\field\Entity\FieldStorageConfig::loadByName('taxonomy_term', $field_name);

      if ($field->getType() == 'string') {
        $term_value[$field_name] = $value;
      }
      elseif ($field->getType() == 'entity_reference') {
        if ($field->getSetting('target_type') == 'taxonomy_term') {
          if (is_array($value)) {
            foreach ($value as $row_value) {
              $vocabulary_name = _check_vocabulary_name($field_name, $vocabulary['vid']);

              $term_value[$field_name][] = _load_terms($row_value, $vocabulary_name);
              // dpm($row_value . ' - ' . _load_terms($row_value, $vocabulary_name));
            }
          }
        }
        else{
          $term_value[$field_name] = _load_user($value);
        }
      }
    }
  }

  $term = Term::create($term_value);
  $term->save();

  if (isset($term->get('tid')->value)) {
    dpm('create term -' . $term->get('name')->value . ' - tid - ' . $term->get('tid')->value);
  }
}

/**
 * @param field name
 * @return vocabulary_name
 */
function _check_vocabulary_name($field_name = NULL, $bundle = NULL) {
  $vocabulary_name = NULL;

  $entity_type = 'taxonomy_term';

  if ($field_name) {
    $FieldConfig = FieldConfig::loadByName($entity_type, $bundle, $field_name);
    // @return target_bundles array, most of case, only one option
    $target_bundles = $FieldConfig->getSettings()['handler_settings']['target_bundles'];

    if (is_array($target_bundles)) {
      $vocabulary_name = current($target_bundles);
    }
  }
  dpm('$vocabulary_name - ' . $vocabulary_name);

  return $vocabulary_name;
}

function _fetch_convert_json() {
  // internal
  global $base_url;
  $feed_url = $base_url . '/modules/custom/phpdebug/import_data/entity_create_term_json.json';
  $response = \Drupal::httpClient()->get($feed_url, array('headers' => array('Accept' => 'text/plain')));
  $data = $response->getBody();

  $output = json_decode($data, TRUE);
  return  $output;
}
