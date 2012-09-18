<?php

/**
 * Company form base class.
 *
 * @method Company getObject() Returns the current form's model object
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCompanyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'name'              => new sfWidgetFormInputText(),
      'address'           => new sfWidgetFormTextarea(),
      'email'             => new sfWidgetFormInputText(),
      'phone'             => new sfWidgetFormInputText(),
      'fax'               => new sfWidgetFormInputText(),
      'url'               => new sfWidgetFormInputText(),
      'logo'              => new sfWidgetFormTextarea(),
      'currency'          => new sfWidgetFormInputText(),
      'currency_decimals' => new sfWidgetFormInputText(),
      'legal_terms'       => new sfWidgetFormTextarea(),
      'pdf_orientation'   => new sfWidgetFormInputText(),
      'pdf_size'          => new sfWidgetFormInputText(),
      'user_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'              => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'address'           => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'email'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fax'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'url'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'logo'              => new sfValidatorString(array('required' => false)),
      'currency'          => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'currency_decimals' => new sfValidatorInteger(array('required' => false)),
      'legal_terms'       => new sfValidatorString(array('required' => false)),
      'pdf_orientation'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'pdf_size'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'user_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Company', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('company[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Company';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['user_list']))
    {
      $this->setDefault('user_list', $this->object->User->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveUserList($con);

    parent::doSave($con);
  }

  public function saveUserList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['user_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->User->getPrimaryKeys();
    $values = $this->getValue('user_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('User', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('User', array_values($link));
    }
  }

}
