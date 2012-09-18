<?php

/**
 * CompanyUser form base class.
 *
 * @method CompanyUser getObject() Returns the current form's model object
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCompanyUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'       => new sfWidgetFormInputHidden(),
      'sf_guard_user_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'company_id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('company_id')), 'empty_value' => $this->getObject()->get('company_id'), 'required' => false)),
      'sf_guard_user_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('sf_guard_user_id')), 'empty_value' => $this->getObject()->get('sf_guard_user_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyUser';
  }

}
