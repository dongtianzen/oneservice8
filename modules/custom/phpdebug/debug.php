<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/debug.php');
  _print_class();
  _query_nodes();
 */

// use Drupal\Core\Controller\ControllerBase;
// use Drupal\Core\Entity\EntityManagerInterface;
// use Drupal\Core\Entity\Query\QueryFactory;

// use Symfony\Component\DependencyInjection\ContainerInterface;

// use Drupal\nodeinfo\Controller\NodeinfoQueryController;
use \Drupal\dashpage\Controller\DashpageController;
function _print_class() {
  $val = 33;
  dpm($val . ' is :');

  $cc = new DashpageController();
  $methods = get_class_methods($cc);
  dpm($cc);
  dpm($methods);
}

function _state_value($key = NULL) {
  $val = \Drupal::state()->get($key);
  dpm($key . ' is :');
  // dpm($val);
}

/**
 *
 require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/debug.php');
 _service_keyvalue(3);
 */
function _service_keyvalue($key = NULL) {
  $KeyValueFactory = \Drupal::keyValue('dino_variable');
  $val = $KeyValueFactory->get('roar_3');

  dpm($val);

  $val = $KeyValueFactory->delete('roar_3');



  $val = $KeyValueFactory->get('roar_3');
  dpm($val);
}

function _field_print() {
  $nid = 5;
  $node  = \Drupal::entityTypeManager()->getStorage('node')->load($nid);

  dpm($node->uid->entity->name->value);
  dpm(render($node->uid->entity->name));
}

function _query_nodes() {
  // $NodeinfoQueryController = \Drupal\nodeinfo\Controller\NodeinfoQueryController::create();
  // $NodeinfoQueryController = new \Drupal\nodeinfo\Controller\NodeinfoQueryController;
  // $entity_manager = new \Drupal\Core\Entity\EntityManagerInterface();
  // $entity_query = new \Drupal::QueryFactory();
  $NodeinfoQueryController = new NodeinfoQueryController();
  $NodeinfoQueryController->basicQuery();
  dpm(66);
}

function _query_node() {
  $query = $QueryFactory->entity_query->get('node');

  // Add a filter (published).
  $query->condition('status', 1);

  // Run the query.
  $nids = $query->execute();
}

function _storage_load_node() {
  $nid = 5;
  $node  = \Drupal::entityTypeManager()->getStorage('node')->load($nid);

  $methods = get_class_methods($node);
  // dpm($methods);
  dpm($node->get('title')->value);
  dpm($node->get('body')->value);
  dpm($node->get('field_tags')->value);
}

// use entityTypeManager;
function _create_node() {
  $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
  $field_array = array(
    'type' => 'article',
    'title' => 'The title3',
    'langcode' => $language,
    'uid' => 1,
    'status' => 1,
    'body' => array('The body text'),
    'field_date' => array("2010-01-30"),
    //'field_fields' => array('Custom values'), // Add your custom field values like this
    // 'field_image' => array(
    //   'target_id' => $fileID,
    //   'alt' => "My alt",
    //   'title' => "My title",
    // ),
  );

  // create node object
  $node = \Drupal::entityTypeManager()->getStorage('node')->create($field_array);

  \Drupal::entityTypeManager()->getStorage('node')->save($node);
}

// use \Drupal\node\Entity\Node;
function _create_node2() {
  $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
  $node = \Drupal\node\Entity\Node::create(array(
    'type' => 'article',
    'title' => 'The title2',
    'langcode' => $language,
    'uid' => 1,
    'status' => 1,
    'body' => array('The body text'),
  ));

  $node->save();
}

function _edit_node($nid = NULL) {
  $node  = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
  if ($node) {
    // $node->set($field_name, $field_value);
    $node->set('title', 'new title');

    $node->save();
  }
}

/**
 *
   require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/debug.php');
  _get_node(3);
 */
function _get_node($nid = NULL) {
  $node  = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
  // Entity reference
  dpm('// tid value - ');
  dpm($node->get('field_page_tags')->target_id);

  dpm('// tids getValue() 0 - ');
  dpm($node->get('field_page_tags')->getValue()[0]['target_id']);

  dpm('// tids getValue() - ');
  dpm($node->get('field_page_tags')->getValue());

  dpm('<hr />');

  // Text (plain)
  dpm('// city value - ');
  dpm($node->get('field_page_city')->value);

  dpm('// city getValue() - ');
  dpm($node->get('field_page_city')->getValue());
}

/**
 *
   require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/debug.php');
  _get_field(3);
 */
function _get_field($entity_id = NULL) {
  $entity_storage = \Drupal::entityTypeManager()->getStorage('node');
  $entity = $entity_storage->load($entity_id);

  $field_name = 'field_page_city';
  $field_name = 'body';
  $field = $entity->get($field_name);
// dpm($field);
dpm($field->value);

}

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/debug.php');
  _set_field_value(3);
 */
function _set_field_value($entity_id = NULL) {
  $entity = \Drupal::entityTypeManager()->getStorage('node')->load($entity_id);

  $field_name = 'field_page_city';
  $field = $entity->get($field_name);
  dpm($entity->get($field_name)->value);

  $field_values = $field->getValue();
  $field_values[0]['value'] = 'London';
  $field->setValue($field_values);
  $entity->save();

  $entity = \Drupal::entityTypeManager()->getStorage('node')->load($entity_id);
  dpm($entity->get($field_name)->value);
}

/**
 * Obtaining information about the field
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/debug.php');
  _get_field_information(3);
 */
function _get_field_information($entity_id = NULL) {
  $entity = \Drupal::entityTypeManager()->getStorage('node')->load($entity_id);
  $field = $entity->get('field_page_city');

  $definition = $field->getFieldDefinition();
  $field_name = $definition->get('field_name');
  $field_type = $definition->get('field_type');

  dpm($field_name);
  dpm($field_type);
}
