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
    $common_defaults = array(
                             'name' => 'Client Name',
                             'identification'=>'Client Legal Id',
                             'contact_person'=> 'Contact Person',
                             'invoicing_address' => 'Invoicing Address',
                             'shipping_address'=> 'Shipping Address',
                             'email'=> 'Client Email Address',
                             'phone'=> 'Client Phone',
                             'fax'=> 'Client Fax',
                             'comments'=> 'Comments',
                             );

    $this->widgetSchema['tags']  = new sfWidgetFormInputHidden();
    $this->validatorSchema['tags']           = new sfValidatorString(array('required'=>false));

    $this->widgetSchema['payment_type_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PaymentType'),'table_method' => 'getCurrentCompany', 'add_empty' => true));
    //Assign company_id from session values.
    $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('company_id' , sfContext::getInstance()->getUser()->getAttribute('company_id'));
    $this->setDefault('tags', implode(',',$this->object->getTags()));

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
