<?php
class CompanySearchForm extends BaseForm
{
  public function configure()
  {    
    $this->setWidgets(array(
      'query'       => new sfWidgetFormInputText(),
    ));

    $this->widgetSchema->setLabels(array(
      'query'       => 'Search',
    ));

    $this->setValidators(array(
      'query'       => new sfValidatorString(array('required' => false, 'trim' => true)),
    ));
    
    $this->widgetSchema->setNameFormat('search[%s]');
    $this->widgetSchema->setFormFormatterName('list');
  }
  
}
