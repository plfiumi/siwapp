<?php
class ProductSearchForm extends BaseForm
{
  public function configure()
  {
    $startYear = sfConfig::get('app_year_range_start', date('Y') - 5);
    $years = range($startYear, date('Y') + 5);

    $this->setWidgets(array(
      'query'       => new sfWidgetFormInputText(),
      'category' =>  new sfWidgetFormDoctrineChoice(array('model' => 'ProductCategory','table_method' => 'getCurrentCompany', 'add_empty' => true)),
    ));

    $this->widgetSchema->setLabels(array(
      'query'       => 'Search',
      'category' => 'Category',
                                         ));
    
    $this->setValidators(array(
      'query'       => new sfValidatorString(array('required' => false, 'trim' => true)),
    ));
    
    $this->widgetSchema->setNameFormat('search[%s]');
    $this->widgetSchema->setFormFormatterName('list');
  }
  
}
