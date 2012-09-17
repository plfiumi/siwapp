<?php
/**
 * Product Categories List
 * @author Sergi Almacellas <sergi.almacellas@btactic.com>
 */
class ProductCategoryList extends FormsContainer
{
  
  public function configure()
  {
    $culture = $this->getOption('culture', sfConfig::get('sf_default_culture'));

    $this->embedForm('product_categories',new ProductCategoriesForm());
    
    $this->widgetSchema->setNameFormat('categories[%s]');

  }

  public function addNewForm($key, $where, $form)
  {
    $this->embeddedForms[$where]->embedForm($key, $form);
    $this->embedForm($where, $this->embeddedForms[$where]);
  }
}
