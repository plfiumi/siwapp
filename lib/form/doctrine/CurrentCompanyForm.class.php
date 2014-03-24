<?php

/**
 * Company form.
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CurrentCompanyForm extends CompanyForm
{

  private function getCurrentCompany()
  {
    $companyObject = new Company();
    $companyObject = $companyObject->loadById(sfContext::getInstance()->getUser()->getAttribute('company_id'));
    return $companyObject;
  }
     
  public function configure()
  {
    parent::configure();
    unset($this->widgetSchema['user_list']);
    unset($this->validatorSchema['user_list']);
    $this->widgetSchema['invoice_legal_terms'] = new sfWidgetFormTextarea(array(), array('cols' => '30', 'rows' => '7'));
    $this->widgetSchema['estimate_legal_terms'] = new sfWidgetFormTextarea(array(), array('cols' => '30', 'rows' => '7'));
    
    $companyObject = $this->getCurrentCompany();
    
    $this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Logo',
      'file_src'  => self::getUploadsDir().'/'.$companyObject->getLogo(),
      'is_image'  => true,
      'edit_mode' => is_file(sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.$companyObject->getLogo()),
      'template'  => '<div id="logo_container"><div>%file%<br/>%input%</div><div class="dl">%delete% %delete_label%</div><div>'
    ));
    
    $this->validatorSchema['logo'] = new sfValidatorFile(array(
                                     'mime_types' => 'web_images', 
                                     'required' => false, 
                                     'validated_file_class'=>'SiwappValidatedFile',
                                     'path'      => sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR
                             ));
    $this->validatorSchema['logo_delete'] = new sfValidatorPass();
    $this->validatorSchema['company_user_list'] = new sfValidatorPass();


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
   * @author Carlos Escribano <carlos@markhaus.com>
   **/
  public function save($con = null)
  {
    parent::save();
    $currency_decimals = sfConfig::get('app_currency_decimals', array());

    foreach ($this->getValues() as $key => $value)
    {
       switch ($key)
       {
            case 'logo':
                $companyObject = $this->getCurrentCompany();
	            if (("on" == $this->getValue('logo_delete')) && is_file($old = sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.$companyObject->getLogo()))
	            {
	                @ unlink($old);
	                $companyObject->setLogo(null);
	                $companyObject->save();
	            }

	            if ($value)
	            {
	                $fname = $value->generateFilename();
                    $value->save(sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.$fname);
	                $companyObject->setLogo($fname);
	                $companyObject->save();
	            }
	          break;

	        case 'logo_delete':
	          break;
	
	        default:
	          break;
        }
    }
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
    try
    {
      //TODO: This method saves the logo but it breaks. 
      $values['logo']->canSave();
    }
    catch(Exception $e)
    {
      $validator->setMessage('invalid',$validator->getMessage('invalid').': '.$e->getMessage());
      throw new sfValidatorError($validator,'invalid');
    }
    return $values;

  }

}
