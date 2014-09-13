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
    //unset($this['shipping_address']);
    $this->widgetSchema['supplier_business_name']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Business Name'));
    $this->widgetSchema['supplier_email']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Supplier Email Address'));
    $this->widgetSchema['supplier_name']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Name/Legal Name'));
    $this->widgetSchema['supplier_identification']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Supplier Legal Id'));
    $this->widgetSchema['supplier_phone']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Phone'));
    $this->widgetSchema['supplier_fax']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Fax'));
    $this->widgetSchema['supplier_mobile']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Mobile'));
    $this->widgetSchema['supplier_comments']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Comments'));
    $this->widgetSchema['supplier_tax_condition']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Tax condition'));
    
    
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
    $this->validatorSchema['supplier_identification']  = new sfValidatorString(array('required' => true));
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
