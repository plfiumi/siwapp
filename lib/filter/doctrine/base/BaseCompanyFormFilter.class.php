<?php

/**
 * Company filter form base class.
 *
 * @package    siwapp
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCompanyFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'identification'    => new sfWidgetFormFilterInput(),
      'name'              => new sfWidgetFormFilterInput(),
      'address'           => new sfWidgetFormFilterInput(),
      'email'             => new sfWidgetFormFilterInput(),
      'phone'             => new sfWidgetFormFilterInput(),
      'fax'               => new sfWidgetFormFilterInput(),
      'url'               => new sfWidgetFormFilterInput(),
      'logo'              => new sfWidgetFormFilterInput(),
      'currency'          => new sfWidgetFormFilterInput(),
      'currency_decimals' => new sfWidgetFormFilterInput(),
      'legal_terms'       => new sfWidgetFormFilterInput(),
      'pdf_orientation'   => new sfWidgetFormFilterInput(),
      'pdf_size'          => new sfWidgetFormFilterInput(),
      'company_user_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'identification'    => new sfValidatorPass(array('required' => false)),
      'name'              => new sfValidatorPass(array('required' => false)),
      'address'           => new sfValidatorPass(array('required' => false)),
      'email'             => new sfValidatorPass(array('required' => false)),
      'phone'             => new sfValidatorPass(array('required' => false)),
      'fax'               => new sfValidatorPass(array('required' => false)),
      'url'               => new sfValidatorPass(array('required' => false)),
      'logo'              => new sfValidatorPass(array('required' => false)),
      'currency'          => new sfValidatorPass(array('required' => false)),
      'currency_decimals' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'legal_terms'       => new sfValidatorPass(array('required' => false)),
      'pdf_orientation'   => new sfValidatorPass(array('required' => false)),
      'pdf_size'          => new sfValidatorPass(array('required' => false)),
      'company_user_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCompanyUserListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.CompanyUser CompanyUser')
      ->andWhereIn('CompanyUser.sf_guard_user_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Company';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'identification'    => 'Text',
      'name'              => 'Text',
      'address'           => 'Text',
      'email'             => 'Text',
      'phone'             => 'Text',
      'fax'               => 'Text',
      'url'               => 'Text',
      'logo'              => 'Text',
      'currency'          => 'Text',
      'currency_decimals' => 'Number',
      'legal_terms'       => 'Text',
      'pdf_orientation'   => 'Text',
      'pdf_size'          => 'Text',
      'company_user_list' => 'ManyKey',
    );
  }
}
