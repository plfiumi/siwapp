<?php

/**
 * Expense form.
 *
 * @package    form
 * @subpackage Expense
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ExpenseForm extends CommonForm
{
  protected $number;

  public function configure($expense = false)
  {
    unset($this['number'], $this['created_at'], $this['updated_at']);
    // we unset paid_amount so the system don't "nullify" the field on every expense editing.
    unset($this['paid_amount']);
    unset($this['shipping_address']);

    $this->number = $this->getObject()->getNumber();
    $this->widgetSchema['issue_date'] =
      new sfWidgetFormI18nJQueryDate($this->JQueryDateOptions);
    $this->widgetSchema['due_date']   =
      new sfWidgetFormI18nJQueryDate($this->JQueryDateOptions);
    $this->widgetSchema['draft']      = new sfWidgetFormInputHidden();
    $this->widgetSchema['default_expense_type']      = new sfWidgetFormInputHidden();
    $this->widgetSchema['closed']->setLabel('Force to be closed');

    $this->widgetSchema['sent_by_email']->setLabel('Sent by email');

    $this->setDefaults(array(
      'issue_date'              => time(),
      'draft'                   => 0
      ));


    $this->validatorSchema['supplier_email'] = new sfValidatorEmail(
                                                     array(
                                                       'max_length' => 100,
                                                       'required' => false
                                                       ),
                                                     array(
                                                       'invalid' => 'Invalid client email address'
                                                       )
                                                     );

    $this->validatorSchema['supplier_name']  = new sfValidatorString(array('required' => true));
    $this->validatorSchema['supplier_reference']  = new sfValidatorString(array('required' => true));
    $this->validatorSchema['default_expense_type'] = new sfValidatorPass();

    $this->widgetSchema->setNameFormat('expense[%s]');
    parent::configure(true);
    //Override validations:
    $this->validatorSchema['customer_email'] = new sfValidatorString(array('max_length' => 100, 'required' => false));
    $this->validatorSchema['customer_name']  =  new sfValidatorString(array('max_length' => 100, 'required' => false));
    $this->validatorSchema['series_id'] = new sfValidatorDoctrineChoice(
            array('model' => $this->getRelatedModelName('Series'),
            'required' => false));
  }

  public function getModelName()
  {
    return 'Expense';
  }

}
