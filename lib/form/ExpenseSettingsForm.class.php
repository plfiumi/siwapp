<?php
/**
 * Expenses Settings Form
 * 
 * @author Pablo L. Fiumidinisi <plfiumi@gmail.com>
 */
class ExpensesSettingsForm extends FormsContainer
{
  
  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();
    $invalid_message = $i18n->__('Some expenses types have not been deleted because they are currently in use').": <strong>%invalid_expenses%</strong>. ";
    
    $culture = $this->getOption('culture', sfConfig::get('sf_default_culture'));

    $this->embedForm('expenses',new ExpensesTypeForm());
    
        $this->validatorSchema->setPostValidator(new sfValidatorAnd(
        array(
              new sfValidatorCallback(array(
                'callback' => array($this, 'validateExpense')
              ), array(
                'invalid' => $invalid_message
              )),
             )));
    
    $this->widgetSchema->setNameFormat('expenses_settings[%s]');

  }

  public function addNewForm($key, $where, $form)
  {
    $this->embeddedForms[$where]->embedForm($key, $form);
    $this->embedForm($where, $this->embeddedForms[$where]);
  }

  public function save($con = null)
  {
    parent::save();
  }
  
  /**
   * Finds the expensesType to be deleted and if they are still linked to Common instances throws
   * a global error to tell it to the user.
   */
  public function validateExpense(sfValidatorBase $validator, $values, $arguments)
  {
    $deleted_ids = array();
    foreach($values['expenses'] as $key => $expense)
    {
      if($expense['remove'])
      {
        $deleted_ids[] = $expense['id'];
      }
    }
    if(!count($deleted_ids))
    {
      return $values;
    }

   /**
    * Finds the expenses types to be deleted and if they are still linked to items throws
    * a global error to tell it to the user.
    */
    $toDelete = Doctrine_Core::getTable('Item')
      ->createQuery()
      ->from('Item i')
      ->addWhere('i.expense_type_id IN (?)',implode(',',$deleted_ids))->execute();

    if(count($toDelete))
    {
      $invalid = array();
      foreach($toDelete as $k => $expense)
      {
        $expenseTypeToDelete = Doctrine_Core::getTable('ExpenseType')->find($expense->expense_type_id);
        $this->taintedValues['expenses']['old_'.$expenseTypeToDelete->id]['remove'] = '';
        $invalid[] = $expenseTypeToDelete->name;
      }
      throw new sfValidatorErrorSchema($validator,
                                       array(
                                         new sfValidatorError($validator,
                                                              'invalid',
                                                              array(
                                                                'invalid_expenses'=>
                                                                implode(', ',$invalid)))));
    }

    return $values;
  }
  
}
