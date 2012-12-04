<?php
class ProductSearchForm extends BaseForm
{
  public function configure()
  {
    $startYear = sfConfig::get('app_year_range_start', date('Y') - 5);
    $years = range($startYear, date('Y') + 5);

    $sfWidgetFormI18nJQueryDateOptions = array(
      'culture' => $this->getOption('culture', 'en'),
      'image'   => image_path('icons/calendar.png'),
      'config'  => "{ duration: '' }",
      'years'   => array_combine($years, $years)
    );

    $this->setWidgets(array(
      'query'       => new sfWidgetFormInputText(),
      'category' =>  new sfWidgetFormDoctrineChoice(array('model' => 'ProductCategory','table_method' => 'getCurrentCompany', 'add_empty' => true)),
       'from'        => new sfWidgetFormI18nJQueryDate($sfWidgetFormI18nJQueryDateOptions),
      'to'          => new sfWidgetFormI18nJQueryDate($sfWidgetFormI18nJQueryDateOptions),
      'quick_dates' => new sfWidgetFormChoice(array('choices' => InvoiceSearchForm::getQuickDates())),
    ));

    $this->widgetSchema->setLabels(array(
      'query'       => 'Search',
      'category' => 'Category',
      'from'        => 'from',
      'to'          => 'to',
      'quick_dates' => 'Period',
      
                                         ));
    $dateRangeValidatorOptions = array(
      'required'  => false
    );
    $this->setValidators(array(
      'query'       => new sfValidatorString(array('required' => false, 'trim' => true)),
      'from'        => new sfValidatorDate($dateRangeValidatorOptions),
      'to'          => new sfValidatorDate($dateRangeValidatorOptions),
    ));
    
    $this->widgetSchema->setNameFormat('search[%s]');
    $this->widgetSchema->setFormFormatterName('list');
  }
  
}
