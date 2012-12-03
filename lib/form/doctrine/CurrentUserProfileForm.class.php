<?php

/**
 * Profile form.
 *
 * @package    form
 * @subpackage Profile
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CurrentUserProfileForm extends ProfileForm
{
  public function configure()
  {
    parent::configure();
    unset($this->widgetSchema['username']);
    unset($this->widgetSchema['superadmin']);
    unset($this->validatorSchema['username']);

    $this->widgetSchema['old_password']     = new sfWidgetFormInputPassword();
    $this->widgetSchema['new_password2']     = new sfWidgetFormInputPassword();

    $this->validatorSchema['series']           = new sfValidatorDoctrineChoice(
                                                       array(
                                                             'model'=>'Series',
                                                             ),
                                                       array(
                                                             'required' 
                                                               => 'The default invoicing series is mandatory'
                                                             )
                                                       );
    $this->validatorSchema['old_password']   = new sfValidatorPass();

    $vdPassword                              = new sfValidatorCallback(
                                                       array(
                                                         'callback' => array($this,'checkPassword')
                                                         ),
                                                       array(
                                                         'invalid'  => 'Wrong password',
                                                         'required' => 'Old password required'
                                                         )
                                                       );
                                                       
    $passwd_min_length = sfConfig::get('app_password_min_length',4);
    $this->validatorSchema['new_password']     = new sfValidatorPass();
    $vdNewPassword                             = new sfValidatorString(
                                                       array(
                                                             'min_length' => 1,
                                                         'required'=>false
                                                         ),
                                                       array(
                                                         'min_length' => 'Password length must be '.
                                                           "greater than $passwd_min_length"
                                                         )
                                                       );



    $vd = new sfValidatorSchema(
                array(
                      'old_password' => $vdPassword,
                      'new_password' => $vdNewPassword,
                      'new_password2'=> new sfValidatorPass()
                      )
                );
    
    $vd->setPostValidator(
            new sfValidatorSchemaCompare(
                  'new_password','==','new_password2',
                  array(),
                  array('invalid' => "Passwords don't match")
                  )
            );


    $this->validatorSchema->setPostValidator(
                              new SiwappConditionalValidator(
                                    array(
                                      'control_field'    => 'new_password',
                                      'validator_schema' => $vd,
                                      'callback'         => array('Tools','checkLength')
                                      )
                                    )
                              );


    $this->validatorSchema['new_password2']    = new sfValidatorPass();

    $user = sfContext::getInstance()->getUser();
    $this->validatorSchema['sf_guard_user_id'] = new sfValidatorAnd(
                                                   array(
                                                     new sfValidatorDoctrineChoice(
                                                           array(
                                                             'model' => 'sfGuardUser',
                                                             'required' => true
                                                             ), 
                                                           array(
                                                             'invalid' => "The user does not exist!"
                                                             )
                                                           ),
                                                     new CompareValueValidator(
                                                           array(
                                                             'value' => $user->getGuardUser()->getId()
                                                             )
                                                           )
                                                     )
                                                   );
      $this->widgetSchema->setNameFormat('config[%s]');
  }


  public function save($con = null, $currentUser = false)
  {
    if(strlen($this->values['new_password']))
    {
      $this->getOption('user')->setPassword($this->values['new_password']);
    }
    parent::save($con,true);
  }

  public function checkPassword(sfValidatorCallback $validator,$password)
  {
    if(!$this->getOption('user')->checkPassword($password))
    {
      throw new sfValidatorError($validator,'invalid',array('value'=>$password));
    }
    return true;
  }

}
