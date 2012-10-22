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
    
        $this->validatorSchema->setPostValidator(new sfValidatorAnd(
        array(
          new sfValidatorCallback(array(
              'callback' => array($this, 'validateCategories')
            ), array(
              'invalid' => 'Some categories have not been deleted because they are currently in use: <strong>%invalid_categories%</strong>.'
            )),
        )));
    
    $this->widgetSchema->setNameFormat('product_categories[%s]');

  }

  public function addNewForm($key, $where, $form)
  {
    $this->embeddedForms[$where]->embedForm($key, $form);
    $this->embedForm($where, $this->embeddedForms[$where]);
  }

  public function save($con = null)
  {
    parent::save();
  }
  
    /**
   * Finds the categories to be deleted and if they are still linked to items throws
   * a global error to tell it to the user.
   */
  public function validateCategories(sfValidatorBase $validator, $values, $arguments)
  {
    $deleted_ids = array();
    foreach($values['product_categories'] as $key => $category)
    {
      if($category['remove'])
      {
        $deleted_ids[] = $category['id'];
      }
    }
    if(!count($deleted_ids))
    {
      return $values;
    }

    $toDelete = Doctrine_Core::getTable('Product')
      ->createQuery()
      ->addWhere('category_id IN (?)',implode(',',$deleted_ids))->execute();

    if(count($toDelete))
    {
      $invalid = array();
      foreach($toDelete as $k => $category)
      {
        $this->taintedValues['product_categories']['old_'.$category->id]['remove'] = '';
        $invalid[] = $category->name;
      }
      throw new sfValidatorErrorSchema($validator, 
                                       array(
                                             new sfValidatorError($validator, 
                                                                  'invalid',
                                                                  array(
                                                                    'invalid_categories'=>
                                                                      implode(', ',$invalid)))));
    }
    
    return $values;
  }
}
