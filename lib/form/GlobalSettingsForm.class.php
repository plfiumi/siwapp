<?php
/**
 * Global Settings Form
 * @author Carlos Escribano <carlos@markhaus.com>
 */
class GlobalSettingsForm extends FormsContainer
{

  public function configure()
  {
    $culture = $this->getOption('culture', sfConfig::get('sf_default_culture'));
    
    //Embed Company Form:
    $this->embedForm('company',new CompanyGlobalSettingsForm());
    /* TAXES & SERIES*/
    $this->embedForm('taxes',new TaxesForm());
    $this->embedForm('seriess',new SeriessForm());
    /* Expenses Type */
//    $this->embedForm('expenses',new ExpensesTypeForm());
    $this->embedForm('payments',new PaymentsTypeForm());

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(
        array(
          new sfValidatorCallback(array(
              'callback' => array($this, 'validateTaxes')
            ), array(
              'invalid' => 'Some taxes have not been deleted because they are currently in use: <strong>%invalid_taxes%</strong>.'
            )),
          new sfValidatorCallback(array(
              'callback' => array($this, 'validateSeries')
            ), array(
              'invalid' => 'Some series have not been deleted because they are currently in use: <strong>%invalid_series%</strong>.'
            )),
//          new sfValidatorCallback(array(
//              'callback' => array($this, 'validateExpense')
//            ), array(
//              'invalid' => 'Some expenses have not been deleted because they are currently in use: <strong>%invalid_expenses%</strong>.'
//            )),
         new sfValidatorCallback(array(
              'callback' => array($this, 'validatePayments')
            ), array(
              'invalid' => 'Some payments have not been deleted because they are currently in use: <strong>%invalid_payments%</strong>.'
            )),
        )));

    $this->widgetSchema->setNameFormat('config[%s]');
    $this->widgetSchema->setFormFormatterName('listB');

  }
  
  public function addNewForm($key, $where, $form)
  {
    $this->embeddedForms[$where]->embedForm($key, $form);
    $this->embedForm($where, $this->embeddedForms[$where]);
  }
  
  /**
   * Finds the taxes to be deleted and if they are still linked to items throws
   * a global error to tell it to the user.
   */
  public function validateTaxes(sfValidatorBase $validator, $values, $arguments)
  {
    $deleted_ids = array();
    foreach($values['taxes'] as $key => $tax)
    {
      if($tax['remove'])
      {
        $deleted_ids[] = $tax['id'];
      }
    }
    if(!count($deleted_ids))
    {
      return $values;
    }

    $toDelete = Doctrine_Core::getTable('Tax')
      ->createQuery()
      ->from('Tax t')
      ->innerJoin('t.Items it')
      ->addWhere('t.id IN (?)',implode(',',$deleted_ids))->execute();

    if(count($toDelete))
    {
      $invalid = array();
      foreach($toDelete as $k => $tax)
      {
        $this->taintedValues['taxes']['old_'.$tax->id]['remove'] = '';
        $invalid[] = $tax->name;
      }
      throw new sfValidatorErrorSchema($validator, 
                                       array(
                                             new sfValidatorError($validator, 
                                                                  'invalid',
                                                                  array(
                                                                    'invalid_taxes'=>
                                                                      implode(', ',$invalid)))));
    }
    
    return $values;
  }


  /**
   * Finds the series to be deleted and if they are still linked to Common instances throws
   * a global error to tell it to the user.
   */
  public function validateSeries(sfValidatorBase $validator, $values, $arguments)
  {
    $deleted_ids = array();
    foreach($values['seriess'] as $key => $serie)
    {
      if($serie['remove'])
      {
        $deleted_ids[] = $serie['id'];
      }
    }
    if(!count($deleted_ids))
    {
      return $values;
    }

    $toDelete = Doctrine_Core::getTable('Series')
      ->createQuery()
      ->from('Series s')
      ->innerJoin('s.Common c')
      ->addWhere('s.id IN (?)',implode(',',$deleted_ids))->execute();

    if(count($toDelete))
    {
      $invalid = array();
      foreach($toDelete as $k => $serie)
      {
        $this->taintedValues['seriess']['old_'.$serie->id]['remove'] = '';
        $invalid[] = $serie->name;
      }
      throw new sfValidatorErrorSchema($validator,
                                       array(
                                         new sfValidatorError($validator,
                                                              'invalid',
                                                              array(
                                                                'invalid_series'=>
                                                                implode(', ',$invalid)))));
    }

    return $values;
  }


  /**
   * Finds the PaymentType to be deleted and if they are still linked to Common instances throws
   * a global error to tell it to the user.
   */
  public function validatePayments(sfValidatorBase $validator, $values, $arguments)
  {
    $deleted_ids = array();
    foreach($values['payments'] as $key => $expense)
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

    return $values;

    $toDelete = Doctrine_Core::getTable('PaymentType')
      ->createQuery()
      ->from('PaymentType s')
      ->innerJoin('s.Common c')
      ->addWhere('s.id IN (?)',implode(',',$deleted_ids))->execute();

    if(count($toDelete))
    {
      $invalid = array();
      foreach($toDelete as $k => $expense)
      {
        $this->taintedValues['payment']['old_'.$expense->id]['remove'] = '';
        $invalid[] = $expense->name;
      }
      throw new sfValidatorErrorSchema($validator,
                                       array(
                                         new sfValidatorError($validator,
                                                              'invalid',
                                                              array(
                                                                'invalid_payments'=>
                                                                implode(', ',$invalid)))));
    }

    return $values;
  }
  

  
}
