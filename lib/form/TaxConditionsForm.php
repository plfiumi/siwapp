<?php

class TaxConditionsForm extends FormsContainer
{
  public function __construct($options = array(), $CSRFSecret = null)
  {
    $this->old_taxCondition = Doctrine::getTable('TaxCondition')->createQuery()
    ->where('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))->execute();
  
    $forms = array();
    foreach ($this->old_taxCondition as $taxCondition)
    {
      $forms['old_'.$taxCondition->getId()] = new TaxConditionForm($taxCondition, $options, false);
    }
    parent::__construct($forms, 'TaxConditionForm', $options, $CSRFSecret);
  }

  public function configure()
  {
    $this->widgetSchema->setNameFormat('taxConditions[%s]');
  }

}
