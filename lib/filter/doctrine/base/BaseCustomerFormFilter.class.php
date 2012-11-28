<?php

/**
 * Customer filter form base class.
 *
 * @package    siwapp
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCustomerFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'name'                 => new sfWidgetFormFilterInput(),
      'name_slug'            => new sfWidgetFormFilterInput(),
      'identification'       => new sfWidgetFormFilterInput(),
      'email'                => new sfWidgetFormFilterInput(),
      'contact_person'       => new sfWidgetFormFilterInput(),
      'invoicing_address'    => new sfWidgetFormFilterInput(),
      'invoicing_postalcode' => new sfWidgetFormFilterInput(),
      'invoicing_city'       => new sfWidgetFormFilterInput(),
      'invoicing_state'      => new sfWidgetFormFilterInput(),
      'invoicing_country'    => new sfWidgetFormFilterInput(),
      'shipping_address'     => new sfWidgetFormFilterInput(),
      'shipping_postalcode'  => new sfWidgetFormFilterInput(),
      'shipping_city'        => new sfWidgetFormFilterInput(),
      'shipping_state'       => new sfWidgetFormFilterInput(),
      'shipping_country'     => new sfWidgetFormFilterInput(),
      'website'              => new sfWidgetFormFilterInput(),
      'phone'                => new sfWidgetFormFilterInput(),
      'mobile'               => new sfWidgetFormFilterInput(),
      'fax'                  => new sfWidgetFormFilterInput(),
      'comments'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'company_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Company'), 'column' => 'id')),
      'name'                 => new sfValidatorPass(array('required' => false)),
      'name_slug'            => new sfValidatorPass(array('required' => false)),
      'identification'       => new sfValidatorPass(array('required' => false)),
      'email'                => new sfValidatorPass(array('required' => false)),
      'contact_person'       => new sfValidatorPass(array('required' => false)),
      'invoicing_address'    => new sfValidatorPass(array('required' => false)),
      'invoicing_postalcode' => new sfValidatorPass(array('required' => false)),
      'invoicing_city'       => new sfValidatorPass(array('required' => false)),
      'invoicing_state'      => new sfValidatorPass(array('required' => false)),
      'invoicing_country'    => new sfValidatorPass(array('required' => false)),
      'shipping_address'     => new sfValidatorPass(array('required' => false)),
      'shipping_postalcode'  => new sfValidatorPass(array('required' => false)),
      'shipping_city'        => new sfValidatorPass(array('required' => false)),
      'shipping_state'       => new sfValidatorPass(array('required' => false)),
      'shipping_country'     => new sfValidatorPass(array('required' => false)),
      'website'              => new sfValidatorPass(array('required' => false)),
      'phone'                => new sfValidatorPass(array('required' => false)),
      'mobile'               => new sfValidatorPass(array('required' => false)),
      'fax'                  => new sfValidatorPass(array('required' => false)),
      'comments'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('customer_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Customer';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'company_id'           => 'ForeignKey',
      'name'                 => 'Text',
      'name_slug'            => 'Text',
      'identification'       => 'Text',
      'email'                => 'Text',
      'contact_person'       => 'Text',
      'invoicing_address'    => 'Text',
      'invoicing_postalcode' => 'Text',
      'invoicing_city'       => 'Text',
      'invoicing_state'      => 'Text',
      'invoicing_country'    => 'Text',
      'shipping_address'     => 'Text',
      'shipping_postalcode'  => 'Text',
      'shipping_city'        => 'Text',
      'shipping_state'       => 'Text',
      'shipping_country'     => 'Text',
      'website'              => 'Text',
      'phone'                => 'Text',
      'mobile'               => 'Text',
      'fax'                  => 'Text',
      'comments'             => 'Text',
    );
  }
}
