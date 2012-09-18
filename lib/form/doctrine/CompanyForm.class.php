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

    $companyObject = new Company();
    $companyObject = $companyObject->loadById(sfContext::getInstance()->getUser()->getAttribute('company_id'));

    $culture = $this->getOption('culture', sfConfig::get('sf_default_culture'));
    
    $this->widgetSchema['currency'] = new sfWidgetFormI18nChoiceCurrency(array('culture' => $culture));
    $this->widgetSchema['legal_terms'] = new sfWidgetFormTextarea(array(), array('cols' => '30', 'rows' => '7'));
    $this->widgetSchema['pdf_size'] = new sfWidgetFormSelect(array('choices' => self::$paper_sizes));
    $this->widgetSchema['pdf_orientation'] = new sfWidgetFormSelect(array('choices' => array('portrait', 'landscape')));
    
    unset($this->widgetSchema['company_user_list']);
    
    $this->setDefaults(array(
      'id'     => $companyObject->getId(),
      'name'     => $companyObject->getName(),
      'address'  => $companyObject->getAddress(),
      'phone'    => $companyObject->getPhone(),
      'fax'      => $companyObject->getFax(),
      'email'    => $companyObject->getEmail(),
      'url'      => $companyObject->getUrl(),
      'currency'        => $companyObject->getCurrency(),
      'legal_terms'     => $companyObject->getLegalTerms(),
      'pdf_size'        => $companyObject->getPdfSize(),
      'pdf_orientation' => $companyObject->getPdfOrientation(),
    ));

    $this->widgetSchema->setLabels(array(
      'name'     => 'Name',
      'address'  => 'Address',
      'phone'    => 'Phone',
      'fax'      => 'FAX',
      'email'    => 'Email',
      'url'      => 'Web',
      'currency'         => 'Currency',
      'legal_terms'      => 'Terms & Conditions',
      'pdf_size'         => 'Page size',
      'pdf_orientation'  => 'Page orientation'
    ));


    $this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Logo',
      'file_src'  => self::getUploadsDir().'/'.$companyObject->getLogo(),
      'is_image'  => true,
      'edit_mode' => is_file(sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.$companyObject->getLogo()),
      'template'  => '<div id="company_logo_container"><div>%file%<br/>%input%</div><div class="dl">%delete% %delete_label%</div><div>'
    ));

    $this->setValidators(array(
      'logo'        => new sfValidatorFile(array(
                                     'mime_types' => 'web_images', 
                                     'required' => false, 
                                     'validated_file_class'=>'SiwappValidatedFile',
                                     'path'      => sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR
                                     )),
      'logo_delete' => new sfValidatorPass(),
      'currency'            => new sfValidatorString(array('max_length' => 50, 'required' => true)),
      'legal_terms'         => new sfValidatorString(array('required' => false)),
      'pdf_size'            => new sfValidatorString(array('required' => false)),
      'pdf_orientation'     => new sfValidatorString(array('required' => false))
    ));

   $this->validatorSchema->setPostValidator(new sfValidatorAnd(
        array(
          new sfValidatorCallBack(
              array('callback'  => array($this,'checkLogo')),
              array('invalid'   => "Can't upload the logo")
              )
          )
        ));
  }
  
   /**
   * @return void
   * @author Sergi Almacellas <sergi.almacellas@btactic.com>
   **/
  public function save($con = null)
  {
/*
    $currency_decimals = sfConfig::get('app_currency_decimals', array());
    
    foreach ($this->getValues() as $key => $value)
    {
      switch ($key)
      {
        case 'logo':
          if (("on" == $this->getValue('logo_delete')) && is_file($old = sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.PropertyTable::get('logo')))
          {
            @ unlink($old);
            PropertyTable::set('logo', null);
          }
          
          if ($value)
          {
            $fname = $value->generateFilename();
            $value->save(sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.$fname);
            $this->setLogo($fname);
          }
          break;

        case 'logo_delete':
          break;

      }
    }*/
    parent::save();
  }

  public static function getUploadsDir()
  {
    $root_path = substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'/'));
    $web_dir = str_replace(DIRECTORY_SEPARATOR,'/',sfConfig::get('sf_web_dir'));
    $upload_dir = str_replace(DIRECTORY_SEPARATOR,'/',sfConfig::get('sf_upload_dir'));
    return $root_path.str_replace($web_dir, null, $upload_dir);
  }

  public function checkLogo(sfValidatorBase $validator, $values)
  {
    if(!$values['logo'])
    {
      return $values;
    }
    $logoObject = $values['logo'];
    try
    {
      $logoObject->canSave();
    }
    catch(Exception $e)
    {
      $validator->setMessage('invalid',$validator->getMessage('invalid').': '.$e->getMessage());
      throw new sfValidatorError($validator,'invalid');
    }
    return $values;
  }
}
