<?php

/**
 * Supplier form base class.
 *
 * @method Supplier getObject() Returns the current form's model object
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSupplierForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'company_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'name'              => new sfWidgetFormInputText(),
      'name_slug'         => new sfWidgetFormInputText(),
      'identification'    => new sfWidgetFormInputText(),
      'email'             => new sfWidgetFormInputText(),
      'contact_person'    => new sfWidgetFormInputText(),
      'invoicing_address' => new sfWidgetFormTextarea(),
      'phone'             => new sfWidgetFormInputText(),
      'fax'               => new sfWidgetFormInputText(),
      'comments'          => new sfWidgetFormTextarea(),
      'expense_type_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExpenseType'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'company_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'required' => false)),
      'name'              => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'name_slug'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'identification'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'email'             => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'contact_person'    => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'invoicing_address' => new sfValidatorString(array('required' => false)),
      'phone'             => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fax'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'comments'          => new sfValidatorString(array('required' => false)),
      'expense_type_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExpenseType'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('supplier[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Supplier';
  }

}
