<?php

/**
 * @file
 * Contains \Drupal\reactset\Plugin\Field\FieldWidget\ReactsetDefaultWidget.
 */

namespace Drupal\reactset\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'reactset_standard_widget' widget.
 *
 * @FieldWidget(
 *   id = "reactset_standard_widget",
 *   label = @Translation("Reactset Field Widget"),
 *   field_types = {
 *     "reactset_type"
 *   }
 * )
 */
class ReactsetDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'placeholder' => '',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['placeholder'] = array(
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    );
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $placeholder = $this->getSetting('placeholder');
    if (!empty($placeholder)) {
      $summary[] = t('Placeholder: @placeholder', array('@placeholder' => $placeholder));
    }
    else {
      $summary[] = t('No placeholder');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   * @todo add form element which are displyed in the node add/edit form
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // The #default_value accepted by this element is either an entity object or an array of entity objects.
    $parts_tid_default_value = NULL;
    if (isset($items[$delta]->parts_tid)) {
      $parts_tid_default_value = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($items[$delta]->parts_tid);
    }

    $element['parts_tid'] = $element;
    $element['parts_tid'] = array(
      '#title' => t('Parts Term'),
      '#type' => 'entity_autocomplete',
      '#target_type' => 'taxonomy_term',
      '#selection_settings' => ['target_bundles' => ['parts']],
      '#default_value' => $parts_tid_default_value,
      '#placeholder' => $this->getSetting('placeholder'),
    );

    $element['parts_num'] = $element;
    $element['parts_num'] = array(
      '#title' => t('Parts Num'),
      '#type' => 'number',
      '#default_value' => isset($items[$delta]->parts_num) ? $items[$delta]->parts_num : NULL,
      '#placeholder' => $this->getSetting('placeholder'),
      '#maxlength' => 1024,
    );

    return $element;
  }

}
