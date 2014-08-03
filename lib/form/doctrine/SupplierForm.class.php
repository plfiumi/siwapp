<?php

/**
 * Supplier form.
 *
 * @package    form
 * @subpackage Supplier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class SupplierForm extends BaseSupplierForm
{
  public function configure()
  {
    $decorator = new myFormSchemaFormatter($this->getWidgetSchema());
    $this->widgetSchema->addFormFormatter('custom', $decorator);
    $this->widgetSchema->setFormFormatterName('custom');
    $common_defaults = array(
                             'name' => 'Supplier Name',
                             'business_name'=>'Business Name',
                             'identification'=>'Supplier Legal Id',
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
                             'comments'=>'Comments',
                             'tax_condition'=>'Tax condition',
                             'invoicing_series'=>'Invoicing series',
                             'financial_entity'=>'Financial Entity',
                             'financial_entity_office'=>'Office',
                             'financial_entity_account'=>'Account',
                             'login'=>'Login',
                             'password'=>'Password'
                             );

    $this->widgetSchema->setHelps($common_defaults);
    
    $this->widgetSchema['expense_type_id'] = new sfWidgetFormChoice(array('choices' => array(''=>'') + ExpenseTypeTable::getChoicesForSelect()));
    $this->widgetSchema['payment_type_id'] = new sfWidgetFormChoice(array('choices' => array(''=>'') + PaymentTypeTable::getChoicesForSelect()));
    $this->widgetSchema['tax_condition_id'] = new sfWidgetFormChoice(array('choices' => array(''=>'') + TaxConditionTable::getChoicesForSelect()));
    
    //Assign company_id from session values.
    $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('company_id' , sfContext::getInstance()->getUser()->getAttribute('company_id'));

    // placeholders
    $this->widgetSchema['name']->setAttributes(array('placeholder'   => sfContext::getInstance()->getI18N()->__('Name/Legal Name'),
                                                     'autofocus'     => 'autofocus'));
    $this->widgetSchema['business_name']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Legal Id'));
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
    $this->widgetSchema['comments']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Comments'));
    
    $this->widgetSchema['financial_entity']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Financial Entity'));
    $this->widgetSchema['financial_entity_office']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Office'));
    $this->widgetSchema['financial_entity_account']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Account'));
    
    $this->widgetSchema['login']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Login'));
    $this->widgetSchema['password']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Password'));
    
    
    // validators
    $this->validatorSchema['email'] = new sfValidatorEmail(
                                            array(
                                              'max_length'=>100,
                                              'required'  =>false
                                              ),
                                            array(
                                              'invalid' => sfContext::getInstance()->getI18N()->__('Invalid email address')
                                              )
                                            );
    $this->validatorSchema['contact_person_email'] = new sfValidatorEmail(
                                            array(
                                              'max_length'=>100,
                                              'required'  =>false
                                              ),
                                            array(
                                              'invalid' => sfContext::getInstance()->getI18N()->__('Invalid email address')
                                              )
                                            );
    
    $this->validatorSchema['name']->setOption('required', true);
    $this->validatorSchema['identification']->setOption('required', true);
    $this->validatorSchema['name_slug']->
      setMessages(array_merge(array('invalid'=>'sg'),
                              $this->validatorSchema['name_slug']->
                                getMessages()
                              ));
    $this->validatorSchema['expense_type_id']->setOption('required', true);                       
    /* TODO: Commented because it breaks 
    foreach($this->validatorSchema->getPostValidator()->getValidators() as $val)
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
    $taintedValues['name_slug'] = SupplierTable::slugify(
                                                         $taintedValues['name']
                                                         );
    parent::bind($taintedValues, $taintedFiles);
  }
}
