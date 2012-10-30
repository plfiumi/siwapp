<?php

/**
 * Payment filter form base class.
 *
 * @package    siwapp
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePaymentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'invoice_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Common'), 'add_empty' => true)),
      'date'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'amount'          => new sfWidgetFormFilterInput(),
      'payment_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PaymentType'), 'add_empty' => true)),
      'notes'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'company_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Company'), 'column' => 'id')),
      'invoice_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Common'), 'column' => 'id')),
      'date'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'amount'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'payment_type_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PaymentType'), 'column' => 'id')),
      'notes'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('payment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Payment';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'company_id'      => 'ForeignKey',
      'invoice_id'      => 'ForeignKey',
      'date'            => 'Date',
      'amount'          => 'Number',
      'payment_type_id' => 'ForeignKey',
      'notes'           => 'Text',
    );
  }
}
