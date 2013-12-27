<?php

/**
 * Tag form.
 *
 * @package    form
 * @subpackage Tag
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class TagForm extends PluginTagForm
{
  public function configure()
  {
    $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('company_id' , sfContext::getInstance()->getUser()->getAttribute('company_id'));
  }
}
