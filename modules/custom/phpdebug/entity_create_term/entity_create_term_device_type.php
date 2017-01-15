<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/entity_create_term_device_type.php');
  _run_batch_entity_create_terms();
 */

use Drupal\taxonomy\Entity\Term;

function _run_batch_entity_create_terms() {
  $vocabulary = array(
    'vid'  => 'device_type',
  );

  $terms = _entity_terms_info();
  foreach ($terms as $term) {
    _entity_create_terms($vocabulary, $term);
  }
}

function _entity_create_terms($vocabulary, $term) {
  $term = Term::create([
    'name' => $term,
    'vid'  => $vocabulary['vid'],
  ]);
  $term->save();
}

function _entity_terms_info() {
  $terms = array(
    " ",
    "ADP-1000",
    "ADP-2000",
    "ATV",
    "ATX-PSU",
    "bNSG9K",
    "CG-5E-4",
    "CID-3100",
    "DCH-3000P",
    "DCH-4000P",
    "DCH-5000P",
    "E-1000",
    "ELC-7000",
    "ELC-8000",
    "ELC-PSU",
    "Ellipse-1000",
    "Ellipse-2000",
    "Ellipse-3000",
    "ELP-1000-PSU",
    "GSF",
    "ION",
    "ION-PSU",
    "IRD-2600",
    "IRD-2900",
    "IRD-other",
    "IVG-7000",
    "IVG-7304",
    "LIVE U",
    "LU-1000",
    "LU-40i",
    "LU-60",
    "LU-70",
    "LU1000",
    "LU2000",
    "LU40S",
    "LU500",
    "MV",
    "NSG9K-36R-1G",
    "NSG9K-40G",
    "NSG9K-6G",
    "NSG9K-8R-1G",
    "NSG9K-AC-PSU",
    "PBI",
    "PSM-1000",
    "PSM-1000-ASI",
    "PSM-1000-GBE",
    "PSM-2000",
    "PSM-9000",
    "PSM1K-PSU",
    "PVR-7000",
    "PVR-7100",
    "PVR-8100",
    "R1V-2275V(ROHS)",
    "RTM-3300",
    "SFP",
    "StreamBox",
    "UE-9000",
    "UID2912",
    "戴尔PowerEdge R210 II",
  );

  return $terms;
}
