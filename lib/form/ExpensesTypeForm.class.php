<?php

class ExpensesTypeForm extends FormsContainer
{
  public function __construct($options = array(), $CSRFSecret = null)
  {
    $this->old_expenses = Doctrine::getTable('ExpenseType')->createQuery()
    ->where('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))->execute();
  
    $forms = array();
    foreach ($this->old_expenses as $expense)
    {
      $forms['old_'.$expense->getId()] = new ExpenseTypeForm($expense, $options, false);
    }
    parent::__construct($forms, 'ExpenseTypeForm', $options, $CSRFSecret);
  }

  public function configure()
  {
    $this->widgetSchema->setNameFormat('expenses[%s]');
  }

}
