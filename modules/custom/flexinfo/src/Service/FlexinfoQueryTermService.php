<?php

/**
 * @file
 * Contains Drupal\flexinfo\Service\FlexinfoQueryTermService.php.
 */
namespace Drupal\flexinfo\Service;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Query\QueryFactory;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Component\Utility\Timer;
/**
 * An example Service container.
   $FlexinfoQueryTermService = new FlexinfoQueryTermService();
   $FlexinfoQueryTermService->nidsByBundle();
 *
   \Drupal::getContainer()->get('flexinfo.queryterm.service')->programTidsByBusinessunit();
 */
class FlexinfoQueryTermService extends ControllerBase {

  protected $entity_query;

  /**
   * {@inheritdoc}
   */
  public function __construct(QueryFactory $entity_query) {
    $this->entity_query = $entity_query;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.query')
    );
  }

  /** - - - - - - execute - - - - - - - - - - - - - - - - - - - - - - - - -  */

  /**
   * @return array, nids
   */
  public function runQueryWithGroup($query = NULL) {
    $result = $query->execute();

    return array_values($result);
  }

  /** - - - - - - query not run execute() - - - - - - - - - - - - - - - - -  */


  /** - - - - - - Term Group - - - - - - - - - - - - - - - - - - - - - - -  */

  /** - - - - - - other - - - - - - - - - - - - - - - - - - - - - - - - - -  */

  /**
   * @return array, term object
   \Drupal::getContainer()->get('flexinfo.queryterm.service')->programTermsByBusinessunit();
   */
  public function programTermsByBusinessunit($program_terms = array(), $businessunit_tids = array()) {
    $output = array();

    if (is_array($program_terms)) {
      foreach ($program_terms as $program_term) {
        $businessunit_tid = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldTargetId($program_term, 'field_program_businessunit');
        if ($businessunit_tid) {
          if (in_array($businessunit_tid, $businessunit_tids)) {
            $output[] = $program_term;
          }
        }
      }
    }

    return $output;
  }

  /**
   * @return array, term tid
   \Drupal::getContainer()->get('flexinfo.queryterm.service')->programTidsByBusinessunit();
   */
  public function programTidsByBusinessunit($program_tids = array(), $businessunit_tids = array()) {
    $output = array();

    if (is_array($program_tids)) {
      $program_terms = \Drupal::getContainer()->get('flexinfo.term.service')->getTermsFromTids($program_tids);
      foreach ($program_terms as $program_term) {

        if ($program_term) {
          $businessunit_tid = \Drupal::getContainer()->get('flexinfo.field.service')->getFieldTargetId($program_term, 'field_program_businessunit');
          if ($businessunit_tid) {

            if (in_array($businessunit_tid, $businessunit_tids)) {
              $output[] = $program_term->get('tid')->value;
            }
          }
        }
      }
    }

    return $output;
  }

}
