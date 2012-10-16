<?php

class TaxesForm extends FormsContainer
{
  public function __construct($options = array(), $CSRFSecret = null)
  {
    $this->old_taxes = Doctrine::getTable('Tax')->createQuery()
    ->where('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))->execute();
      
    $forms = array();
    foreach ($this->old_taxes as $tax)
    {
      $forms['old_'.$tax->getId()] = new TaxForm($tax, $options, false);
    }
    parent::__construct($forms, 'TaxForm', $options, $CSRFSecret);
  }
  
  public function configure()
  {
    $this->widgetSchema->setNameFormat('taxes[%s]');
  }
  
}
