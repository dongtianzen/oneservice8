<?php

/**
 * @file
 * Contains Drupal\flexinfo\Service\FlexinfoEntityService.php.
 */
namespace Drupal\flexinfo\Service;

/**
 * An example Service container.
  $FlexinfoEntityService = new FlexinfoEntityService();
  $FlexinfoEntityService->getFieldSingleValue();

  \Drupal::getContainer()->get('flexinfo.entity.service')->getEntity($entity_type);
 */
class FlexinfoEntityService {

  /**
   * Entity
   * @param $entity_type
   */
  function getEntity($entity_type) {
    switch ($entity_type) {
      case 'calc':
        $container = \Drupal::getContainer()->get('flexinfo.calc.service');
        break;

      case 'field':
        $container = \Drupal::getContainer()->get('flexinfo.field.service');
        break;

      case 'querynode':
        $container = \Drupal::getContainer()->get('flexinfo.querynode.service');
        break;

      case 'queryterm':
        $container = \Drupal::getContainer()->get('flexinfo.queryterm.service');
        break;

      case 'setting':
        $container = \Drupal::getContainer()->get('flexinfo.setting.service');
        break;

      case 'term':
        $container = \Drupal::getContainer()->get('flexinfo.term.service');
        break;

      case 'user':
        $container = \Drupal::getContainer()->get('flexinfo.user.service');
        break;

      default:
        break;
    }

    return $container;
  }

}
