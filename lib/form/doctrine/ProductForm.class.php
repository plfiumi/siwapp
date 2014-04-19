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

    $this->widgetSchema['company_id'] = new sfWidgetFormInputHidden();

    //Filter categories to the ones that belong to the current company
    $this->widgetSchema['category_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductCategory'),'table_method' => 'getCurrentCompany', 'add_empty' => true));
    
    // placeholders
    $this->widgetSchema['reference']->setAttributes(array('placeholder'   => sfContext::getInstance()->getI18N()->__('Reference'),
                                                          'autofocus'     => 'autofocus'));
    $this->widgetSchema['description']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Description'));
    $this->widgetSchema['price']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Price'));
    $this->widgetSchema['stock']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Stock'));
    $this->widgetSchema['min_stock_level']->setAttribute('placeholder', sfContext::getInstance()->getI18N()->__('Min stock level'));
    
    $common_defaults = array(
                             'reference' => 'Reference',
                             'description'=>'Description',
                             'price'=> 'Price',
                             'stock'=> 'Stock',
                             'min_stock_level'=> 'Min stock level'
                             );
    $this->widgetSchema->setHelps($common_defaults);
    
    $min_stock_level = sfContext::getInstance()->getUser()->getProfile()->getMinStockLevel();
    if (($min_stock_level != null) && is_numeric($min_stock_level)) {
	    $default_values['min_stock_level'] = $min_stock_level;
      
    }
    
    //Assign company_id from session values.
    $default_values['company_id'] = sfContext::getInstance()->getUser()->getAttribute('company_id');
    
    $this->setDefaults($default_values);
  }
}


