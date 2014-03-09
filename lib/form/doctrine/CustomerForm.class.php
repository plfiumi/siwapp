<?php

/**
 * Customer form.
 *
 * @package    form
 * @subpackage Customer
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CustomerForm extends BaseCustomerForm
{
  public function configure()
  {
    $decorator = new myFormSchemaFormatter($this->getWidgetSchema());
    $this->widgetSchema->addFormFormatter('custom', $decorator);
    $this->widgetSchema->setFormFormatterName('custom');
    
    $this->widgetSchema['tags']    = new sfWidgetFormInputHidden();
    $this->validatorSchema['tags'] = new sfValidatorString(array('required'=>false));

    $this->widgetSchema['payment_type_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PaymentType'),'table_method' => 'getCurrentCompany', 'add_empty' => true));
    $this->widgetSchema['series_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Series'), 'add_empty' => true));
    //Assign company_id from session values.
    $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('company_id' , sfContext::getInstance()->getUser()->getAttribute('company_id'));
    $this->setDefault('tags', implode(',',$this->object->getTags()));

    // placeholders
    $this->widgetSchema['name']->setAttributes(array('placeholder'   => sfContext::getInstance()->getI18N()->__('Name/Legal Name'),
                                                     'autofocus'     => 'autofocus'));
    $this->widgetSchema['business_name']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Business Name'));
    $this->widgetSchema['identification']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Legal Id'));
    $this->widgetSchema['phone']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Phone'));
    $this->widgetSchema['fax']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Fax'));
    $this->widgetSchema['mobile']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Mobile'));
    $this->widgetSchema['email']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Email'));
    $this->widgetSchema['website']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Website'));
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
    $this->widgetSchema['shipping_company_data']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Shipping Company Data'));
    $this->widgetSchema['comments']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Comments'));
    
    //$this->widgetSchema['tax_condition']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Tax condition'));
    $this->widgetSchema['discount']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Discount Percentage'));
    $this->widgetSchema['payment_type_id']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Payment type'));
    $this->widgetSchema['financial_entity']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Financial Entity'));
    $this->widgetSchema['financial_entity_office']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Office'));
    $this->widgetSchema['financial_entity_control_digit']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Control digit'));
    $this->widgetSchema['financial_entity_account']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Account'));
    $this->widgetSchema['financial_entity_bic']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('BIC Code'));
    $this->widgetSchema['financial_entity_iban']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('IBAN'));
    
    // tips
    $common_defaults = array(
                             'name' => 'Name/Legal Name',
                             'business_name'=>'Business Name',
                             'identification'=>'Legal Id',
                             'phone'=>'Phone',
                             'fax'=>'Fax',
                             'mobile'=>'Mobile',
                             'email'=>'Email',
                             'website'=>'Website',
                             'contact_person'=>'Contact Person',
                             'contact_person_phone'=>'Phone',
                             'contact_person_email'=>'Email',
                             'invoicing_address'=>'Invoicing Address',
                             'invoicing_city'=>'City',
                             'invoicing_postalcode'=>'Postal code',
                             'invoicing_state'=>'State',
                             'invoicing_country'=>'Country',
                             'shipping_address'=>'Shipping Address',
                             'shipping_city'=>'City',
                             'shipping_postalcode'=>'Postal code',
                             'shipping_state'=>'State',
                             'shipping_country'=>'Country',
                             'shipping_company_data'=>'Shipping Company Data',
                             'comments'=>'Comments',
        
                             'tax_condition'=>'Tax condition',
                             'invoicing_series'=>'Invoicing series',
                             'discount'=>'Discount Percentage',
                             'payment_type_id'=>'Payment type',
                             'financial_entity'=>'Financial Entity',
                             'financial_entity_office'=>'Office',
                             'financial_entity_control_digit'=>'Control digit',
                             'financial_entity_account'=>'Account',
                             'financial_entity_bic'=>'BIC Code',
                             'financial_entity_iban'=>'IBAN',      
                             );
    $this->widgetSchema->setHelps($common_defaults);
    
    // validators
    $this->validatorSchema['email'] = new sfValidatorEmail(
                                            array(
                                              'max_length'=>100,
                                              'required'  =>false
                                              ),
                                            array(
                                              'invalid' => 'Invalid email address'
                                              )
                                            );
    $this->validatorSchema['name']->setOption('required', true);
    $this->validatorSchema['identification']->setOption('required', true);
    $this->validatorSchema['name_slug']->
      setMessages(array_merge(array('invalid'=>'sg'),
                              $this->validatorSchema['name_slug']->
                                getMessages()
                              ));
    /*foreach($this->validatorSchema->getPostValidator()->getValidators() as $val)
    {
      if($val instanceOf sfValidatorDoctrineUnique and
         $val->getOption('column')==array('name_slug') )
        {
          $val->setMessage(
                           'invalid',
                           'Name too close to one already defined in the db'
                           );
        }

    }*/
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    $taintedValues['name_slug'] = CustomerTable::slugify(
                                                         $taintedValues['name']
                                                         );
    parent::bind($taintedValues, $taintedFiles);
  }

  public function doUpdateObject($values)
  {
    parent::doUpdateObject($values);
    $this->getObject()->setTags($values['tags']);
    $this->getObject()->clearRelated();
  }
}
