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
    $path_args = \Drupal::getContainer()->get('flexinfo.setting.service')->getCurrentPathArgs();
    if (isset($path_args[5]) && $path_args[5] == 'repair' && $path_args[1] == 'superinfo') {

      // superinfo/form/add/node/repair?requestnode=468
      $path_parameters = \Drupal::request()->query->all();
      if ($path_parameters) {
        $parameter_value = reset($path_parameters);

        $node  = \Drupal::entityTypeManager()->getStorage('node')->load($parameter_value);
        if ($node) {
          $field_name = 'field_repair_' . key($path_parameters);
          if (isset($form[$field_name]['widget'])) {
            $form['field_repair_requestnode']['widget'][0]['target_id']['#default_value'] = $node;
          }
        }
      }
    }
  }

}
