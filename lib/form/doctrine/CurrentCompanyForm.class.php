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
     
  public function configure()
  {
    parent::configure();
    unset($this->widgetSchema['company_user_list']);
    unset($this->validatorSchema['company_user_list']);
    
    $companyObject = new Company();
    $companyObject = $companyObject->loadById(sfContext::getInstance()->getUser()->getAttribute('company_id'));
    
    $this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Logo',
      'file_src'  => self::getUploadsDir().'/',//.$companyObject->getLogo(),
      'is_image'  => true,
      'edit_mode' => is_file(sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR),//.$companyObject->getLogo()),
      'template'  => '<div id="company_logo_container"><div>%file%<br/>%input%</div><div class="dl">%delete% %delete_label%</div><div>'
    ));
    
    $this->validatorSchemda['logo'] = new sfValidatorFile(array(
                                     'mime_types' => 'web_images', 
                                     'required' => false, 
                                     'validated_file_class'=>'SiwappValidatedFile',
                                     'path'      => sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR
                             ));
    $this->validatorSchemda['logo_delete'] = new sfValidatorPass();


   $this->validatorSchema->setPostValidator(new sfValidatorAnd(
        array(
          new sfValidatorCallBack(
              array('callback'  => array($this,'checkLogo')),
              array('invalid'   => "Can't upload the logo")
              )
          )
        ));


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
      //TODO: This method saves the logo but it breaks. 
      //$logoObject->canSave();
    }
    catch(Exception $e)
    {
      $validator->setMessage('invalid',$validator->getMessage('invalid').': '.$e->getMessage());
      throw new sfValidatorError($validator,'invalid');
    }
    return $values;

  }

}
