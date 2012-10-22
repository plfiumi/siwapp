<?php

/**
 * PaymentType form.
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PaymentTypeForm extends BasePaymentTypeForm
{
  public function configure()
  {
    unset($this['items_list']);
    $this->widgetSchema['name']->setAttribute('class', 'name');
    $this->widgetSchema['enabled']->setAttribute('class', 'active');
    $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['description'] = new sfWidgetFormInputText();
    $this->setDefaults(array(
      'company_id' => sfContext::getInstance()->getUser()->getAttribute('company_id'),
      ));
    $this->widgetSchema->setFormFormatterName('Xit');
  }
}
