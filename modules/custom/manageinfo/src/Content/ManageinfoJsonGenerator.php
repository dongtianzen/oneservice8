<?php

/**
 * @file
 */

namespace Drupal\manageinfo\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 *
 */
class JsonFormBase {
  private $post_url = NULL;
  private $redirect_url = NULL;

  public function getPostUrl() {
    return $this->post_url;
  }
  public function getRedirectUrl() {
    return $this->redirect_url;
  }

  public function setPostUrl($value = NULL) {
    $this->post_url = $value;
  }
  public function setRedirectUrl($value = NULL) {
    $this->redirect_url = $value;
  }

  /** - - - - - field- - - - - - - - - - - - - - - */

  public function getTextfield($fieldName = NULL, $fieldTitle = NULL, $defaultValue = NULL, $fieldRequired = FALSE) {
    $output = array(
      'fieldTid' => NULL,
      'fieldType' => "textfield",
      'fieldName' => $fieldName,
      'fieldTitle' => $fieldTitle,
      'fieldLabel' => NULL,
      'fieldRequired' => $fieldRequired,
      'defaultValue' => $defaultValue,
      'returnType' => "value",
      'updateStatus' => 0
    );
    return $output;
  }

  public function getSelect($fieldName = NULL, $fieldTitle = NULL, $defaultValue = NULL, $fieldRequired = FALSE, $fieldLabel = NULL) {
    $output = array(
      'fieldTid' => 202,
      'fieldType' => "select",
      'fieldStyle' => "dropDown",
      'fieldName' => $fieldName,
      'fieldTitle' => $fieldTitle,
      'fieldLabel' => $fieldLabel,
      'fieldRequired' => $fieldRequired,
      'defaultValue' => $defaultValue,
      'returnType' => "tid",
      'updateStatus' => 0
    );
    return $output;
  }
}

/**
 * An example controller.
 $ManageinfoJsonGenerator = new ManageinfoJsonGenerator();
 $ManageinfoJsonGenerator->angularForm();
 */
class ManageinfoJsonGenerator extends JsonFormBase {
  /**
   *
   */
  public function angularJson() {
    $this->setPostUrl('page/forms/preform/add');
    $this->setRedirectUrl('page/forms/preform/redirect');

    $output['formInfo'] = array(
      'postUrl' =>  $this->getPostUrl(),
      'redirectUrl' => $this->getRedirectUrl(),
    );

    $form_elements[] = $this->getTextfield('eventRegionName', 'Quesiton 1');
    $form_elements[] = $this->getTextfield('eventRegionName', 'Quesiton 2');
    $form_elements[] = $this->getTextfield('eventRegionName', 'City', 'Windsor');
    $form_elements[] = $this->getTextfield('eventRegionName', 'Province');
    $form_elements[] = $this->getTextfield('eventRegionName', 'Location');

    $options = array(
      array(
        "termTid" => 1,
        "termName" => "Male",
      ),
      array(
        "termTid" => 2,
        "termName" => "Female",
      ),
    );
    $form_elements[] = $this->getSelect('eventRegionName', 'Gender', NULL, FALSE, $options);

    $output['formElementsSection'] = $form_elements;

    return $output;
  }
}
