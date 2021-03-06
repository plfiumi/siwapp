<?php

/**
 * Item form.
 *
 * @package    form
 * @subpackage Item
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ItemForm extends BaseItemForm
{
  public function configure()
  {
    parent::configure();
    $this->widgetSchema['common_id'] = new sfWidgetFormInputHidden();
    
    $this->widgetSchema['product_id'] = new sfWidgetFormInputHidden();
    
    $this->widgetSchema['product_autocomplete'] = new sfWidgetFormInputText(array(), array('size'=>'10', 'class'=>'observable'));
    
    $this->widgetSchema['discount'] = new sfWidgetFormInputText(array(), array('size'=>'3', 'class'=>'observable discount'));
    $this->widgetSchema['quantity'] = new sfWidgetFormInputText(array(), array('size'=>'5', 'class'=>'observable quantity'));
    $this->widgetSchema['unitary_cost'] = new sfWidgetFormInputText(array(), array('size'=>'10', 'class'=>'observable unitary_cost'));
    $this->widgetSchema['description'] = new sfWidgetFormTextarea(array(), array('rows'=>'1', 'class'=>'resizable'));
    $this->widgetSchema['expense_type_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExpenseType'),'table_method' => 'getCurrentCompany'));
    
    //Assign company_id from session values.
    $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('company_id' , sfContext::getInstance()->getUser()->getAttribute('company_id'));
    $this->validatorSchema['taxes_list']->addMessage('invalid',"Can't duplicate taxes");
    $this->validatorSchema->setOption('allow_extra_fields', true);
  }

  public function setDefaults($defaults)
  {
    if(isset($defaults['product_id']))
    {
        $product = Doctrine::getTable('Product')->find($defaults['product_id']);
        $defaults['product_autocomplete'] = $product->getReference();
    }
    parent::setDefaults($defaults);
  }
  public function doUpdateObject($values)
  {
    $this->object->unlink('Taxes');
    $values['Taxes'] = $values['taxes_list'];
    return parent::doUpdateObject($values);
  }

}
