<?php

/**
 * Company form.
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyForm extends BaseCompanyForm
{
      protected static
    $paper_sizes = array(
      "4a0" => "4A0", "2a0" => "2A0", "a0" => "A0", "a1" => "A1", "a2" => "A2", "a3" => "A3", "a4" => "A4", "a5" => "A5", "a6" => "A6", "a7" => "A7", "a8" => "A8", "a9" => "A9", "a10" => "A10", "b0" => "B0", "b1" => "B1", "b2" => "B2", "b3" => "B3", "b4" => "B4", "b5" => "B5", "b6" => "B6", "b7" => "B7", "b8" => "B8", "b9" => "B9", "b10" => "B10", "c0" => "C0", "c1" => "C1", "c2" => "C2", "c3" => "C3", "c4" => "C4", "c5" => "C5", "c6" => "C6", "c7" => "C7", "c8" => "C8", "c9" => "C9", "c10" => "C10", "ra0" => "RA0", "ra1" => "RA1", "ra2" => "RA2", "ra3" => "RA3", "ra4" => "RA4", "sra0" => "SRA0", "sra1" => "SRA1", "sra2" => "SRA2", "sra3" => "SRA3", "sra4" => "SRA4", "letter" => "Letter", "legal" => "Legal", "ledger" => "Ledger", "tabloid" => "Tabloid", "executive" => "Executive", "folio" => "Folio", "commerical #10 envelope" => "Commercial #10 Envelope", "catalog #10 1/2 envelope" => "Catalog #10 1/2 Envelope", "8.5x11" => "8.5x11", "8.5x14" => "8.5x14", "11x17" => "11x17"
    );

  public function configure()
  {
    parent::configure();
    $decorator = new myFormSchemaFormatter($this->getWidgetSchema());
    $this->widgetSchema->addFormFormatter('custom', $decorator);
    $this->widgetSchema->setFormFormatterName('custom');
    
    $culture = $this->getOption('culture', sfConfig::get('sf_default_culture'));
    
    $this->widgetSchema['currency'] = new sfWidgetFormI18nChoiceCurrency(array('culture' => $culture));
    $this->widgetSchema['invoice_legal_terms'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['estimate_legal_terms'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['pdf_size'] = new sfWidgetFormSelect(array('choices' => self::$paper_sizes));
    $this->widgetSchema['pdf_orientation'] = new sfWidgetFormSelect(array('choices' => array('portrait', 'landscape')));
    
    // if user is not superadmin, get only users created by him
    if (!sfContext::getInstance()->getUser()->isSuperAdmin()) {
      $usersCreated = ProfileTable::getUsersCreated();
      
      $query = Doctrine_Query::create()->from('sfGuardUser u')
                ->whereIn('u.id', $usersCreated)
                ->orderBy('u.username asc');
      
      $this->widgetSchema['company_user_list']  = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'expanded' => true, 'model' => 'sfGuardUser', 'query' => $query));
    } else {
      $this->widgetSchema['company_user_list']  = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'expanded' => true, 'model' => 'sfGuardUser'));
    }

    // placeholders
    $this->widgetSchema['identification']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Identification'));
    $this->widgetSchema['name']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Name'));
    $this->widgetSchema['address']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Address'));
    $this->widgetSchema['postalcode']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Postal code'));
    $this->widgetSchema['city']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('City'));
    $this->widgetSchema['state']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('State'));
    $this->widgetSchema['country']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Country'));
    $this->widgetSchema['email']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Email'));
    $this->widgetSchema['phone']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Phone'));
    $this->widgetSchema['fax']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('FAX'));
    $this->widgetSchema['url']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Url'));
    $this->widgetSchema['financial_entity']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Financial Entity'));
    $this->widgetSchema['financial_entity_office']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Office'));
    $this->widgetSchema['financial_entity_control_digit']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Control digit'));
    $this->widgetSchema['financial_entity_account']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Account'));
    $this->widgetSchema['financial_entity_bic']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('BIC Code'));
    $this->widgetSchema['financial_entity_iban']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('IBAN'));
    $this->widgetSchema['mercantil_registry']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Mercantil Registry'));
    $this->widgetSchema['sufix']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Sufix'));
    
    $this->widgetSchema->setLabels(array(
      'currency'         => 'Currency',
      'pdf_size'         => 'Page size',
      'pdf_orientation'  => 'Page orientation'
    ));

    // tips
    $common_defaults = array(
                             'identification' => 'Identification',
                             'name' => 'Name',
                             'address' => 'Address',
                             'postalcode' => 'Postal code',
                             'city' => 'City',
                             'state' => 'State',
                             'country' => 'Country',
                             'email' => 'Email',
                             'phone' => 'Phone',
                             'fax' => 'FAX',
                             'url' => 'Url',
                             'url' => 'Url',
                             'financial_entity' => 'Financial Entity',
                             'financial_entity_office' => 'Office',
                             'financial_entity_control_digit' => 'Control digit',
                             'financial_entity_account' => 'Account',
                             'financial_entity_bic' => 'BIC Code',
                             'financial_entity_iban' => 'IBAN',
                             'mercantil_registry' => 'Mercantil Registry',
                             'sufix' => 'Sufix',
                             );
    $this->widgetSchema->setHelps($common_defaults);
    
     $this->validatorSchema['identification'] = new sfValidatorString(array('max_length' => 100, 'required' => true));
     $this->validatorSchema['name'] = new sfValidatorString(array('max_length' => 100, 'required' => true));

    $this->validatorSchema['id']  = new sfValidatorPass();
    $this->validatorSchema['company_user_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => true));
    
    $this->setDefault('sufix', '000');

  }

 
}
