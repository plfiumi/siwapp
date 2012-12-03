<?php

/**
 * Profile form.
 *
 * @package    form
 * @subpackage Profile
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ProfileForm extends BaseProfileForm
{
  public function configure()
  {
    $user = sfContext::getInstance()->getUser();
    
    $this->widgetSchema['company_user_list'] =  new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser'));
    
    $this->widgetSchema['series'] = new sfWidgetFormSelect(
                                          array(
                                            'choices' => SeriesTable::getChoicesForSelect()
                                            ));

    
    $this->widgetSchema['username'] = new sfWidgetFormInputText();
    $this->widgetSchema['superadmin'] = new sfWidgetFormInputCheckbox(array(),array('value'=>1));

    $this->widgetSchema['sf_guard_user_id'] = new sfWidgetFormInputHidden();
      
    $this->widgetSchema['language']         = new sfWidgetFormI18nChoiceLanguage(
                                                    array(
                                                      'culture' => $user->getLanguage(),
                                                      'languages' => 
                                                        CultureTools::getAvailableLanguages(),
                                                      )
                                                    );
    $this->widgetSchema['search_filter']    = new sfWidgetFormSelect(
                                                    array(
                                                      'choices'   => InvoiceSearchForm::getQuickDates()
                                                      )
                                                    );
    

    $this->widgetSchema['new_password']    = new sfWidgetFormInputPassword();
    $this->validatorSchema['superadmin']   = new sfValidatorPass();
    $this->validatorSchema['username']= new sfValidatorString(array('max_length' => 128));

    $this->validatorSchema['language']         = new sfValidatorI18nChoiceLanguage(
                                                       array('required' => true)
                                                       );
    $this->validatorSchema['country']          = new sfValidatorI18nChoiceCountry(
                                                       array('required' => false)
                                                       );

    $this->validatorSchema['search_filter']    = new sfValidatorChoice(
                                                       array(
                                                         'required' => false,
                                                         'choices'  => 
                                                           array_keys(
                                                             InvoiceSearchForm::getQuickDates()
                                                             )
                                                         )
                                                       );
    $this->validatorSchema['email']            = new sfValidatorEmail(
                                                       array(
                                                         'max_length' => 100, 
                                                         'required' => true
                                                         )
                                                       );

    $passwd_min_length = sfConfig::get('app_password_min_length',4);
    $this->validatorSchema['new_password']     = new sfValidatorString(
                                                       array(
                                                             'min_length' => 1,
                                                         'required'=>false
                                                         ),
                                                       array(
                                                         'min_length' => 'Password length must be '.
                                                           "greater than $passwd_min_length"
                                                         )
                                                       );


    
    $this->widgetSchema->setLabels(array(
        'nb_display_results'  => 'Results to display in listings',
        'language'            => 'Interface language',
        'series'              => 'Default invoicing series',
        'old_password'        => 'Old password',
        'new_password'        => 'New password',
        'new_password2'       => 'New password (confirmation)',
        'first_name'          => 'First Name',
        'last_name'          => 'Last Name'
      ));
      
    $this->setDefaults(array(
        'nb_display_results'  => 10,
        'language'            => $user->getLanguage(),
        'country'             => $user->getCountry(),
        'username'            => $this->getOption('username'),
        'superadmin'          => $this->getOption('superadmin'),
      ));
     
    $this->widgetSchema->setNameFormat('profile[%s]');
    //Allow extra fields
    $this->validatorSchema->setOption('allow_extra_fields', true);
    
  }

  public function save($con = null, $currentUser = false)
  {
    $id = parent::save($con);
    $values=$this->getValues();
    if(!$currentUser)
    {
        $name = $values['username'];
        $salt = md5(rand(100000, 999999) . $name);
        $pass = $values['new_password'];
        $superadmin = $values['superadmin'] ? 1 : 0 ;

        if (is_null($values['sf_guard_user_id']))
        {
            $user = new SfGuardUser();
            $user->setUsername($name);
            $user->setAlgorithm('sha1');
            $user->setSalt($salt);
            $user->setPassword($pass);
            $user->setIsActive(true);
            $user->setIsSuperAdmin($superadmin);
            $user->save();
            $this->getObject()->setUser($user);
            $this->getObject()->save();
        }
        else if(strlen($this->values['new_password']))
        {
            $user = Doctrine_Core::getTable('sfGuardUser')->find($values['sf_guard_user_id']);
            $user->setPassword($pass);
            $user->setIsSuperAdmin($superadmin);
            $user->save();
        } else {
            $user = Doctrine_Core::getTable('sfGuardUser')->find($values['sf_guard_user_id']);
            $user->setIsSuperAdmin($superadmin);
            $user->save();
        }
    }

    return $id;
  }



}
