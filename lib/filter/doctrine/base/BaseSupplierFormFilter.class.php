<?php

/**
 * Supplier filter form base class.
 *
 * @package    siwapp
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSupplierFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'name'                     => new sfWidgetFormFilterInput(),
      'name_slug'                => new sfWidgetFormFilterInput(),
      'business_name'            => new sfWidgetFormFilterInput(),
      'identification'           => new sfWidgetFormFilterInput(),
      'email'                    => new sfWidgetFormFilterInput(),
      'contact_person'           => new sfWidgetFormFilterInput(),
      'contact_person_phone'     => new sfWidgetFormFilterInput(),
      'contact_person_email'     => new sfWidgetFormFilterInput(),
      'invoicing_address'        => new sfWidgetFormFilterInput(),
      'invoicing_postalcode'     => new sfWidgetFormFilterInput(),
      'invoicing_city'           => new sfWidgetFormFilterInput(),
      'invoicing_state'          => new sfWidgetFormFilterInput(),
      'invoicing_country'        => new sfWidgetFormFilterInput(),
      'website'                  => new sfWidgetFormFilterInput(),
      'phone'                    => new sfWidgetFormFilterInput(),
      'mobile'                   => new sfWidgetFormFilterInput(),
      'fax'                      => new sfWidgetFormFilterInput(),
      'comments'                 => new sfWidgetFormFilterInput(),
      'tax_condition_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxCondition'), 'add_empty' => true)),
      'financial_entity'         => new sfWidgetFormFilterInput(),
      'financial_entity_office'  => new sfWidgetFormFilterInput(),
      'financial_entity_account' => new sfWidgetFormFilterInput(),
      'payment_type_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PaymentType'), 'add_empty' => true)),
      'login'                    => new sfWidgetFormFilterInput(),
      'password'                 => new sfWidgetFormFilterInput(),
      'expense_type_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExpenseType'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'company_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Company'), 'column' => 'id')),
      'name'                     => new sfValidatorPass(array('required' => false)),
      'name_slug'                => new sfValidatorPass(array('required' => false)),
      'business_name'            => new sfValidatorPass(array('required' => false)),
      'identification'           => new sfValidatorPass(array('required' => false)),
      'email'                    => new sfValidatorPass(array('required' => false)),
      'contact_person'           => new sfValidatorPass(array('required' => false)),
      'contact_person_phone'     => new sfValidatorPass(array('required' => false)),
      'contact_person_email'     => new sfValidatorPass(array('required' => false)),
      'invoicing_address'        => new sfValidatorPass(array('required' => false)),
      'invoicing_postalcode'     => new sfValidatorPass(array('required' => false)),
      'invoicing_city'           => new sfValidatorPass(array('required' => false)),
      'invoicing_state'          => new sfValidatorPass(array('required' => false)),
      'invoicing_country'        => new sfValidatorPass(array('required' => false)),
      'website'                  => new sfValidatorPass(array('required' => false)),
      'phone'                    => new sfValidatorPass(array('required' => false)),
      'mobile'                   => new sfValidatorPass(array('required' => false)),
      'fax'                      => new sfValidatorPass(array('required' => false)),
      'comments'                 => new sfValidatorPass(array('required' => false)),
      'tax_condition_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TaxCondition'), 'column' => 'id')),
      'financial_entity'         => new sfValidatorPass(array('required' => false)),
      'financial_entity_office'  => new sfValidatorPass(array('required' => false)),
      'financial_entity_account' => new sfValidatorPass(array('required' => false)),
      'payment_type_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PaymentType'), 'column' => 'id')),
      'login'                    => new sfValidatorPass(array('required' => false)),
      'password'                 => new sfValidatorPass(array('required' => false)),
      'expense_type_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ExpenseType'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('supplier_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Supplier';
  }

  public function getFields()
  {
    return array(
      'id'                       => 'Number',
      'company_id'               => 'ForeignKey',
      'name'                     => 'Text',
      'name_slug'                => 'Text',
      'business_name'            => 'Text',
      'identification'           => 'Text',
      'email'                    => 'Text',
      'contact_person'           => 'Text',
      'contact_person_phone'     => 'Text',
      'contact_person_email'     => 'Text',
      'invoicing_address'        => 'Text',
      'invoicing_postalcode'     => 'Text',
      'invoicing_city'           => 'Text',
      'invoicing_state'          => 'Text',
      'invoicing_country'        => 'Text',
      'website'                  => 'Text',
      'phone'                    => 'Text',
      'mobile'                   => 'Text',
      'fax'                      => 'Text',
      'comments'                 => 'Text',
      'tax_condition_id'         => 'ForeignKey',
      'financial_entity'         => 'Text',
      'financial_entity_office'  => 'Text',
      'financial_entity_account' => 'Text',
      'payment_type_id'          => 'ForeignKey',
      'login'                    => 'Text',
      'password'                 => 'Text',
      'expense_type_id'          => 'ForeignKey',
    );
  }
}
