<?php

/**
 * @file
 * Contains Drupal\flexinfo\Service\FlexinfoCalcService.php.
 */
namespace Drupal\flexinfo\Service;

/**
 * An example Service container.
   $FlexinfoCalcService = new FlexinfoCalcService();
   $FlexinfoCalcService->getSumValue();
 *
   \Drupal::getContainer()->get('flexinfo.calc.service')->getSumValue();
 */
class FlexinfoCalcService {

  /**
   * @return
   \Drupal::getContainer()->get('flexinfo.calc.service')->getSumFromNodes();
   */
  public function getSumFromNodes($entity_array = array(), $count_field = NULL) {
    $output = '';

    if (!$count_field) {
      $output = count($entity_array);
    }
    else {
      $output = array_sum(
        \Drupal::getContainer()->get('flexinfo.field.service')->getFieldValueArray($entity_array, $count_field)
      );
    }

    return $output;
  }

  /**
   * @return
   */
  public function getSumValue($entity_array = array(), $entity = NULL) {
    $output = '';

    return $output;
  }

  /**
   * avoid number 2 is zero or null
   \Drupal::getContainer()->get('flexinfo.calc.service')->getPercentage();
   */
  public function getPercentage($num1 = NULL, $num2 = NULL) {
    $output = 0;

    if ($num2 > 0) {
      $output = ($num1 / $num2) * 100;
    }

    return $output;
  }

  /**
   * avoid number 2 is zero or null
   \Drupal::getContainer()->get('flexinfo.calc.service')->getPercentageDecimal()
   */
  public function getPercentageDecimal($num1 = NULL, $num2 = NULL, $decimals = 2) {
    $result = $this->getPercentage($num1, $num2);
    $output = number_format((float)$result, $decimals, '.', '');

    return $output;
  }

}
