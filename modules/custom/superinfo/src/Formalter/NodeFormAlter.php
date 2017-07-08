<?php

/**
 * @file
 */

namespace Drupal\superinfo\FormAlter;

/**
 * An example controller.
   $NodeFormAlter = new NodeFormAlter();
   $NodeFormAlter->nodeRepairFormAlter($form);
 */
class NodeFormAlter {

  /**
   * @inherit hook_form_alter()
   */
  public function nodeRepairFormAlter(&$form) {
    $this->nodeFormSetReferenceNode($form, $entity_type = 'repair');
  }

  /**
   * @inherit hook_form_alter()
   */
  public function nodeQuoteFormAlter(&$form) {
    $this->nodeFormSetReferenceNode($form, $entity_type = 'quote');
  }

  /**
   * @inherit hook_form_alter()
   */
  public function nodeFormSetReferenceNode(&$form, $entity_type = 'repair') {
    $path_args = \Drupal::getContainer()->get('flexinfo.setting.service')->getCurrentPathArgs();
    if ($path_args[1] == 'superinfo') {
      if (isset($path_args[5]) && $path_args[5] == $entity_type) {

        // superinfo/form/add/node/repair?requestnode=468
        $path_parameters = \Drupal::request()->query->all();
        if ($path_parameters) {
          $parameter_value = reset($path_parameters);

          $node  = \Drupal::entityTypeManager()->getStorage('node')->load($parameter_value);
          if ($node) {
            $field_name = 'field_' . $entity_type . '_' . key($path_parameters);
            if (isset($form[$field_name]['widget'])) {
              $form[$field_name]['widget'][0]['target_id']['#default_value'] = $node;
            }
          }
        }
      }
    }
  }

}
