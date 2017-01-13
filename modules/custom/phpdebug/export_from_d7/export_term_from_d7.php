
<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/export_from_d7/export_term_from_d7.php');
  _state_value(3);
 */

function _state_value($key = NULL) {
  dpm($key . ' is :');
}
