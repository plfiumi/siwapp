<?php

/**
 * Estimate form.
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EstimateForm extends BaseEstimateForm
{
  /**
   * @see CommonForm
   */
  
  public function configure()
  {
    unset($this['number'], $this['due_date'], $this['closed'], $this['created_at'], $this['updated_at'], $this['series_id']);
    
    $this->widgetSchema['issue_date'] = new sfWidgetFormI18nJQueryDate($this->JQueryDateOptions);
    $this->widgetSchema['draft'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['status'] = new sfWidgetFormChoice(array('choices'=>Estimate::getStatusArray()));
    
    $this->widgetSchema->setNameFormat('invoice[%s]');

    parent::configure();

    $this->setDefaults(array('draft'=>0,'issue_date' => time(),'status' => 2, 'company_id' => sfContext::getInstance()->getUser()->getAttribute('company_id') ));
    $this->validatorSchema['series_id']= new sfValidatorPass();
  }
}
