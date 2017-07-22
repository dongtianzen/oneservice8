<?php

/**
 * @file
 * Contains \Drupal\reactset\Plugin\Field\FieldType\ReactsetType.
 */

namespace Drupal\reactset\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'reactset_type' field type.
 *
 * @FieldType(
 *   id = "reactset_type",
 *   label = @Translation("Reactset Type"),
 *   description = @Translation("This Compound field type stores Reactset answer Field in the database."),
 *   category = @Translation("ZenSet"),
 *   default_widget = "reactset_standard_widget",
 *   default_formatter = "reactset_default_format"
 * )
 */
class ReactsetType extends FieldItemBase {

  /**
   * {@inheritdoc}
   * @return an array using the same format as hook_schema() implementations.
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'parts_tid' => array(
          'description' => 'The parts term tid.',
          'type' => 'int',
          'not full' => TRUE,
          'default' => 0,
        ),
        'parts_num' => array(
          'description' => 'The parts number.',
          'type' => 'int',
          'not full' => FALSE,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   * @todo set column property values such as label and description
   * @todo provide meta data for field properties
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['parts_tid'] = DataDefinition::create('string')
      ->setLabel(t('Parts Tid'))
      ->setDescription(t('Parts Term Tid'))
      ->setRequired(FALSE);

    $properties['parts_num'] = DataDefinition::create('string')
      ->setLabel(t('Parts Num'))
      ->setDescription(t('Parts Num'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   * @todo determine whether the list contains any nonempty items
   * @todo Tell Drupal when a value should be considered empty
   * help Drupal understand whether a field item should be considered empty
   * If this method returns FALSE, Drupal knows that the field has some value which needs to be validated and saved
   */
  public function isEmpty() {
    $parts_tid = $this->get('parts_tid')->getValue();
    $parts_num = $this->get('parts_num')->getValue();

    // parts_tid can't be empty
    return empty($parts_tid) && empty($parts_num);
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints = parent::getConstraints();

    // This value should be a valid number.
    // $constraints[] = $constraint_manager->create('ComplexData', array(
    //   'parts_tid' => array(
    //     'Range' => array(
    //       'min' => 0,
    //       'minMessage' => t('%name: The Question Tid must be larger or equal to %min.', array(
    //         '%name' => $this->getFieldDefinition()->getLabel(),
    //         '%min' => 0,
    //       )),
    //     ),
    //   ),
    // ));

    $constraints[] = $constraint_manager->create('ComplexData', array(
      'parts_num' => array(
        'Range' => array(
          'min' => 0,
          'minMessage' => t('%name: The Question Tid must be larger or equal to %min.', array(
            '%name' => $this->getFieldDefinition()->getLabel(),
            '%min' => 0,
          )),
        ),
      ),
    ));

    return $constraints;
  }

  /**
   * {@inheritdoc}
   * generateSampleValue(), Devel generate automatically use the values returned
   * by this method during the generate process for generate placeholder field values.
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $min = 0;
    $max = 999;
    $values['parts_tid'] = mt_rand($min, $max);

    $random = new Random();
    $values['parts_num'] = $random->word(mt_rand(1, $field_definition->getSetting('max_length')));
    return $values;
  }

}
