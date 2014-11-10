<?php

/**
 * Profile form base class.
 *
 * @method Profile getObject() Returns the current form's model object
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProfileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'sf_guard_user_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'first_name'         => new sfWidgetFormInputText(),
      'last_name'          => new sfWidgetFormInputText(),
      'email'              => new sfWidgetFormInputText(),
      'nb_display_results' => new sfWidgetFormInputText(),
      'language'           => new sfWidgetFormInputText(),
      'country'            => new sfWidgetFormInputText(),
      'search_filter'      => new sfWidgetFormInputText(),
      'series'             => new sfWidgetFormInputText(),
      'time_to_due'        => new sfWidgetFormInputText(),
      'min_stock_level'    => new sfWidgetFormInputText(),
      'hash'               => new sfWidgetFormInputText(),
      'created_by_user_id' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'sf_guard_user_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'first_name'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'last_name'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'email'              => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'nb_display_results' => new sfValidatorInteger(array('required' => false)),
      'language'           => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'country'            => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'search_filter'      => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'series'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'time_to_due'        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'min_stock_level'    => new sfValidatorInteger(array('required' => false)),
      'hash'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_by_user_id' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Profile', 'column' => array('email')))
    );

    $this->widgetSchema->setNameFormat('profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Profile';
  }

}
