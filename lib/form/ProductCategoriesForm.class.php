<?php

class ProductCategoriesForm extends FormsContainer
{
  public function __construct($options = array(), $CSRFSecret = null)
  {
    $this->old_product_category = Doctrine::getTable('ProductCategory')->createQuery()
    ->where('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))->execute();
  
    $forms = array();
    foreach ($this->old_product_category as $product_category)
    {
      $forms['old_'.$product_category->getId()] = new ProductCategoryForm($product_category, $options, false);
    }
    parent::__construct($forms, 'ProductCategoryForm', $options, $CSRFSecret);
  }

}
