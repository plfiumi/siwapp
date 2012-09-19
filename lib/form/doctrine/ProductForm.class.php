<?php

/**
 * Product form.
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductForm extends BaseProductForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at']);
    $decorator = new myFormSchemaFormatter($this->getWidgetSchema());
    $this->widgetSchema->addFormFormatter('custom', $decorator);
    $this->widgetSchema->setFormFormatterName('custom');
    $common_defaults = array(
                             'reference' => 'Product reference',
                             'description'=>'Product description',
                             'price'=> 'Product price'
                             );

    //Assign company_id from session values.
    $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('company_id' , sfContext::getInstance()->getUser()->getAttribute('company_id'));

    //Filter categories to the ones that belong to the current company
    $this->widgetSchema['category_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductCategory'),'table_method' => 'getCurrentCompany', 'add_empty' => true));
    $this->widgetSchema->setHelps($common_defaults);

  }
}


