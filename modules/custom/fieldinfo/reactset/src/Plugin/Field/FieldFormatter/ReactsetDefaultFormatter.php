<?php

/**
 * @file
 * Contains \Drupal\reactset\Plugin\Field\FieldWidget\ReactsetDefaultFormatter.
 */

namespace Drupal\reactset\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'reactset_default_format' formatter.
 *
 * @FieldFormatter(
 *   id = "reactset_default_format",
 *   label = @Translation("Reactset Formatter"),
 *   field_types = {
 *     "reactset_type"
 *   }
 * )
 */
class ReactsetDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'title' => 'defaultSettings title',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements['title'] = array(
      '#type' => 'textfield',
      '#title' => t('ReactsetDefaultFormatter to replace basic textfield display'),
      '#default_value' => $this->getSetting('title'),
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();
    $settings = $this->getSettings();

    if (!empty($settings['title'])) {
      $summary[] = t('ReactsetDefaultFormatter fields using text: @title', array('@title' => $settings['title']));
    }
    else {
      $summary[] = t('ReactsetDefaultFormatter using provided compound field.');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   * @to renderable array for table theme markup
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $rows = array();
    $title_setting = $this->getSetting('title');

    foreach ($items as $delta => $item) {
      $parts_tid_text = $item->parts_tid;
      if ($item->parts_tid) {
        $parts_term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($item->parts_tid);
        if ($parts_term->getName()) {
          $parts_tid_text = $parts_term->getName() . ' - ' . $item->parts_tid;
        }
      }

      // Render each element as table row.
      $rows[] = array(
        'data' => array(
          $parts_tid_text,
          $item->parts_num,
        ),
      );
    }

    $headers = array(
      t('Parts Tid'),
      t('Parts Num'),
    );

    $table = array(
      '#type'   => 'table',
      '#header' => $headers,
      '#rows'   => $rows,
      '#empty'  => t('No reactset information available'),
      '#attributes' => array('id' => 'reactset-table', ),
    );

    return $element = array('#markup' => drupal_render($table));
  }

}
