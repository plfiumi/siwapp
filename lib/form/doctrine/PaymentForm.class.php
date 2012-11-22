<?php

/**
 * Payment form.
 *
 * @package    form
 * @subpackage Payment
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class PaymentForm extends BasePaymentForm
{
  public function configure()
  {
    $this->widgetSchema['invoice_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['amount'] = new sfWidgetFormInputText(array(), array('class' => 'amount'));
    $this->widgetSchema['notes'] = new sfWidgetFormInputText(array(), array('class' => 'notes'));
    $this->widgetSchema['date']  = new sfWidgetFormI18nJQueryDate($this->JQueryDateOptions);
    
   $query = Doctrine::getTable('PaymentType')->createQuery()->addWhere('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'));
$this->widgetSchema['payment_type_id']->setOption('query', $query);

    //Assign company_id from session values.
    $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();

    $this->widgetSchema->setLabels(array(
      'date'   => 'Date',
      'amount' => 'Amount',
      'notes'  => 'Notes'
    ));
    
    $this->setDefaults(array(
      'date'   => time(),
      'company_id' => sfContext::getInstance()->getUser()->getAttribute('company_id'),
    ));
    
    $this->widgetSchema->setFormFormatterName('xit');
  }
  
}
