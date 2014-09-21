<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardValidatorUser.class.php 7904 2008-03-15 13:18:36Z fabien $
 */
class sfGuardValidatorUser extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('username_field', 'username');
    $this->addOption('password_field', 'password');
    $this->addOption('throw_global_error', false);

    $sf_i18n = sfContext::getInstance()->getI18n();
    $message = $sf_i18n->__('The username and/or password is invalid.');
    $this->setMessage('invalid', $message);
  }

  protected function doClean($values)
  {
    $username = isset($values[$this->getOption('username_field')]) ? $values[$this->getOption('username_field')] : '';
    $password = isset($values[$this->getOption('password_field')]) ? $values[$this->getOption('password_field')] : '';

    // user exists?
    if ($user = Doctrine::getTable('sfGuardUser')->findOneByUsername($username))
    {
      // password is ok?
      if ($user->checkPassword($password))
      {
         if (!Doctrine::getTable('sfGuardUser')->findOneByUsername($username)->getIsActive())
        {
         $sf_i18n = sfContext::getInstance()->getI18n();
         $message = $sf_i18n->__('Your license is expired.');
      	 $this->setMessage('invalid', $message);
      	 throw new sfValidatorErrorSchema($this, array($this->getOption('username_field') => new sfValidatorError($this, 'invalid')));
        }
        return array_merge($values, array('user' => $user));
      }
    }

    if ($this->getOption('throw_global_error'))
    {
      throw new sfValidatorError($this, 'invalid');
    }

    throw new sfValidatorErrorSchema($this, array($this->getOption('username_field') => new sfValidatorError($this, 'invalid')));
  }
}
