<?php

/**
 *
  from mildder8 run on lillyglobal
  require_once('/Applications/AMPPS/www/mildder8/modules/custom/phpdebug/export_from_d7/export_d7_term.php');
  _taxonomyGetTreeTidNames();
 */

  /**
   * NotificationPrimary
   */
  function _term_method_collections_7() {
    $output['vid'] = 7;
    $output['field_name'] = array(
      array(
        'd7_field_name' => 'field_notify_mail_to',
        'd8_field_name' => 'field_notify_mailto',
      ),
      array(
        'd7_field_name' => 'field_notify_mail_title',
        'd8_field_name' => 'field_notify_mailtitle',
      ),
      array(
        'd7_field_name' => 'field_notify_mail_content',
        'd8_field_name' => 'field_notify_mailcontent',
      ),
      array(
        'd7_field_name' => 'field_notify_ahead_time',
        'd8_field_name' => 'field_notify_aheadtime',
      ),
      array(
        'd7_field_name' => 'field_notify_enable_status',
        'd8_field_name' => 'field_notify_enablestatus',
      ),
    );

    return $output;
  }
