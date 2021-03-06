<?php

class PaymentsTypeForm extends FormsContainer
{
  public function __construct($options = array(), $CSRFSecret = null)
  {
    $this->old_Payment = Doctrine::getTable('PaymentType')->createQuery()
    ->where('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))->execute();
  
    $forms = array();
    foreach ($this->old_Payment as $expense)
    {
      $forms['old_'.$expense->getId()] = new PaymentTypeForm($expense, $options, false);
    }
    parent::__construct($forms, 'PaymentTypeForm', $options, $CSRFSecret);
  }

  public function configure()
  {
    $this->widgetSchema->setNameFormat('payments[%s]');
  }

}
