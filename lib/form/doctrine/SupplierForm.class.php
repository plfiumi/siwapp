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
                             'identification'=>'Supplier Legal Id',
                             'contact_person'=> 'Contact Person',
                             'invoicing_address' => 'Invoicing Address',
                             'shipping_address'=> 'Shipping Address',
                             'email'=> 'Supplier Email Address',
                             'phone'=> 'Supplier Phone',
                             'fax'=> 'Supplier Fax',
                             'comments'=> 'Comments',
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
    $this->validatorSchema['name_slug']->
      setMessages(array_merge(array('invalid'=>'sg'),
                              $this->validatorSchema['name_slug']->
                                getMessages()
                              ));
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

    }
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    $taintedValues['name_slug'] = SupplierTable::slugify(
                                                         $taintedValues['name']
                                                         );
    parent::bind($taintedValues, $taintedFiles);
  }
}
