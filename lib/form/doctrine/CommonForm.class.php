<?php

/**
 * Common form.
 *
 * @package    form
 * @subpackage Common
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CommonForm extends BaseCommonForm
{

  protected $expense = false;

  public function setup()
  {
    parent::setup();
  }

  public function configure($expense = false)
  {
    $decorator = new myFormSchemaFormatter($this->getWidgetSchema());
    $this->widgetSchema->addFormFormatter('custom', $decorator);
    $this->widgetSchema->setFormFormatterName('custom');
    $common_fields = Doctrine::getTable(self::getModelName())->getColumnNames();
    $model_fields = Doctrine::getTable($this->getModelName())->getColumnNames();
    foreach(array_diff($common_fields,$model_fields) as $extra)
    {
      unset($this[$extra]);
    }
    $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['customer_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['supplier_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['recurring_invoice_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['estimate_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['tags']  = new sfWidgetFormInputHidden();
    $this->widgetSchema['payment_type_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PaymentType'), 'add_empty' => true)); //new sfWidgetFormChoice(array('choices' => array(''=>'') + PaymentTypeTable::getChoicesForSelect()));
    $this->widgetSchema['type']  = new sfWidgetFormInputHidden(array(),
      array('value'=>$this->getModelName()));
    
    $this->widgetSchema['series_id'] = new sfWidgetFormSelect(array(
      'choices' => SeriesTable::getChoicesForSelect()));
    $this->widgetSchema['series_id']->setDefault(
      sfContext::getInstance()->getUser()->getProfile()->getSeries());

    $this->widgetSchema['terms'] = new sfWidgetFormTextarea();
    $this->widgetSchema['shipping_company_data'] = new sfWidgetFormTextarea();

    // placeholders
    $this->widgetSchema['customer_name']->setAttributes(array('placeholder'   => sfContext::getInstance()->getI18N()->__('Name/Legal Name'),
                                                     'autofocus'     => 'autofocus'));
    $this->widgetSchema['customer_business_name']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Business Name'));
    $this->widgetSchema['customer_identification']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Legal Id'));
    $this->widgetSchema['customer_phone']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Phone'));
    $this->widgetSchema['customer_fax']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Fax'));
    $this->widgetSchema['customer_mobile']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Mobile'));
    $this->widgetSchema['customer_email']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Email'));
    $this->widgetSchema['contact_person']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Contact Person'));
    $this->widgetSchema['contact_person_phone']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Phone'));
    $this->widgetSchema['contact_person_email']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Email'));
    $this->widgetSchema['invoicing_address']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Invoicing Address'));
    $this->widgetSchema['invoicing_city']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('City'));
    $this->widgetSchema['invoicing_postalcode']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Postal code'));
    $this->widgetSchema['invoicing_state']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('State'));
    $this->widgetSchema['invoicing_country']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Country'));
    $this->widgetSchema['shipping_address']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Shipping Address'));
    $this->widgetSchema['shipping_city']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('City'));
    $this->widgetSchema['shipping_postalcode']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Postal code'));
    $this->widgetSchema['shipping_state']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('State'));
    $this->widgetSchema['shipping_country']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Country'));
    $this->widgetSchema['customer_comments']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Comments'));
    $this->widgetSchema['customer_tax_condition']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Tax condition'));
    
    // tips
    $common_defaults = array(
                            'customer_name'=>'Name/Legal Name',
                            'customer_business_name'=>'Business Name',
                            'customer_identification'=>'Legal Id',
                            'customer_phone'=>'Phone',
                            'customer_fax'=>'Fax',
                            'customer_mobile'=>'Mobile',
                            'customer_email'=> 'Email',
                            'contact_person'=> 'Contact Person',
                            'contact_person_phone'=> 'Phone',
                            'contact_person_email'=> 'Email',
                            'invoicing_address'=> 'Invoicing Address',
                            'invoicing_city'=> 'City',
                            'invoicing_postalcode'=> 'Postal code',
                            'invoicing_state'=> 'State',
                            'invoicing_country'=> 'Country',
                            'shipping_address'=> 'Shipping Address',
                            'shipping_city'=> 'City',
                            'shipping_postalcode'=> 'Postal code',
                            'shipping_state'=> 'State',
                            'shipping_country'=> 'Country',
                            'customer_comments'=> 'Comments',
                            'customer_tax_condition'=> 'Tax condition'
                             );
    $this->widgetSchema->setHelps(array_merge($this->widgetSchema->getHelps(),$common_defaults));

    $this->setDefault('company_id' , sfContext::getInstance()->getUser()->getAttribute('company_id'));
    $this->setDefault('tags', implode(',',$this->object->getTags()));
    $companyObject = new Company();
    $companyObject = $companyObject->loadById(sfContext::getInstance()->getUser()->getAttribute('company_id'));
    //$this->setDefault('terms', $companyObject->getLegalTerms());
    
    // validators
    $this->validatorSchema['tags']           = new sfValidatorString(array('required'=>false));
    $this->validatorSchema['customer_email'] = new sfValidatorEmail(
                                                     array(
                                                       'max_length' => 100, 
                                                       'required' => false
                                                       ),
                                                     array(
                                                       'invalid' => 'Invalid client email address'
                                                       )
                                                     );
    $this->validatorSchema['customer_name']  = new sfValidatorString(array('required' => true));


    $this->validatorSchema['series_id']  = new sfValidatorString(array('required'=>true),array('required'=>'The invoice serie is mandatory'));
    
    $iforms = array();
    sfContext::getInstance()->getLogger()->info("Expense ==".$this->expense);
    foreach($this->object->getItems() as $item)
    {
      $iforms[$item->id] = new ItemForm($item);
      if($expense)
      {
        $iforms[$item->id]->validatorSchema['expense_type_id']->setOption('required',true);
      }
    }

    $itemForms = new FormsContainer($iforms,'ItemForm');
    
    $this->embedForm('Items', $itemForms);
  }


  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    if(isset($taintedValues['Items']))
    {
      $this->embeddedForms['Items']->fixEmbedded($taintedValues['Items']);
      $this->embedForm('Items',$this->embeddedForms['Items']);
    }
    
    parent::bind($taintedValues, $taintedFiles);
  }

  public function doUpdateObject($values)
  {
    parent::doUpdateObject($values);
    $this->getObject()->setTags($values['tags']);
    $this->getObject()->clearRelated();
  }

  public function saveEmbeddedForms($con = null, $forms = null)
  {
    $this->embeddedForms['Items']->addFixed('common_id',$this->object->id);
    parent::saveEmbeddedForms($con,$forms);
  }

}
