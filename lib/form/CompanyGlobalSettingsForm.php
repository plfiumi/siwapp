<?php

class CompanyGlobalSettingsForm extends FormsContainer
{
  public function __construct($options = array(), $CSRFSecret = null)
  {
    $companyObject = new Company();
    $companyObject = $companyObject->loadById(sfContext::getInstance()->getUser()->getAttribute('company_id'));
    $forms = array(new CurrentCompanyForm($companyObject, $options, false));
    parent::__construct($forms, 'CurrentCompanyForm', $options, $CSRFSecret);
  }
  
  public function configure()
  {
    $this->widgetSchema->setNameFormat('company[%s]');
  }
  
}
