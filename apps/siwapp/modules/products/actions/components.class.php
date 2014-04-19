<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of components
 *
 * @author Pablo Fiumidinisi (plfiumi@gmail.com)
 */
class productsComponents extends sfComponents
{
  public function executeCheckStock()
  {
    $q = Doctrine_Core::getTable('Product')
          ->createQuery()
          ->select('COUNT(id)')
          ->where('stock <= min_stock_level');
    
    $stockAlerts = $q->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
    
    if (!$stockAlerts) {
      $stockAlerts = 0;
    }
    
    $this->stockAlerts = $stockAlerts;
  }
}

?>
