<?php
class ExpenseSearchForm extends BaseForm
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
      'from'        => new sfWidgetFormI18nJQueryDate($sfWidgetFormI18nJQueryDateOptions),
      'to'          => new sfWidgetFormI18nJQueryDate($sfWidgetFormI18nJQueryDateOptions),
      'quick_dates' => new sfWidgetFormChoice(array('choices' => InvoiceSearchForm::getQuickDates())),
      'supplier_id' => new sfWidgetFormChoice(array('choices' => array())),
      'tags'        => new sfWidgetFormInputHidden(),
      'status'      => new sfWidgetFormInputHidden(),
    ));

    $this->widgetSchema->setLabels(array(
      'query'       => 'Search',
      'from'        => 'from',
      'to'          => 'to',
      'quick_dates' => 'Periode',
      'series_id'   => 'Series',
      'supplier_id' => 'Supplier',
      'sent'        => 'Sent',
    ));

    $dateRangeValidatorOptions = array(
      'required'  => false
    );

    $this->setValidators(array(
      'query'       => new sfValidatorString(array('required' => false, 'trim' => true)),
      'from'        => new sfValidatorDate($dateRangeValidatorOptions),
      'to'          => new sfValidatorDate($dateRangeValidatorOptions),
      'supplier_id' => new sfValidatorString(array('required' => false, 'trim' => true)),
      'tags'        => new sfValidatorString(array('required' => false, 'trim' => true)),
      'status'      => new sfValidatorString(array('required' => false, 'trim' => true)),
    ));
    
    // autocomplete for customer
    $this->widgetSchema['supplier_id']->setOption('renderer_class', 'sfWidgetFormJQueryAutocompleter');
    $this->widgetSchema['supplier_id']->setOption('renderer_options', array(
      'url'   => url_for('search/ajaxSupplierAutocomplete'),
      'value_callback' => 'SupplierTable::getSupplierName'
    ));
    
    $this->widgetSchema->setNameFormat('search[%s]');
    $this->widgetSchema->setFormFormatterName('list');
  }

}
