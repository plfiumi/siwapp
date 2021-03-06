<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SupplierTable extends Doctrine_Table
{
  /**
   * simplify a string for matching
   *
   * @return string
   * @author Enrique Martinez
   **/
  public static function slugify($text)
  {
    $conv_text = iconv("UTF-8", "US-ASCII//TRANSLIT", $text);
    if (trim($conv_text) == '') 
    {
        // cyrillic has no possible translit so we return the text
        return trim($text);
    }
    
    $conv_text = preg_replace('/\W+/', null, $conv_text);
    $conv_text = strtolower(trim($conv_text));
    
    return $conv_text;
  }

  /**
   * checks if there is a match in Supplier name
   * on the client table
   *
   * @return Client  -- the client matched
   * @author Enrique Martinez
   **/
  public function matchName($text,$company_id)
  {
    return $this->createQuery()
      ->where('name_slug = ?', self::slugify($text))
      ->AndWhere('company_id = ?', $company_id)
      ->fetchONe();
  }
  
  /**
   * Updates a Supplier object matching the object's data.
   *
   * @return void
   * @author Carlos Escribano <carlos@markhaus.com>
   **/
  public function updateSupplier($obj)
  {
    $Supplier = $this->getSupplierMatch($obj);
    if($Supplier->isNew())
    {
      $Supplier->setDataFrom($obj);
    }
    $obj->setSupplier($Supplier);
    $Supplier->save();
  }
  
  /**
   * gets the Supplier that matches the invoice data
   * If no match returns a new Supplier object
   *
   * @param Invoice|RecurringInvoice -- the invoice or the recurring one.
   * @return Supplier  -- the Supplier matched
   * @author Enrique Martinez
   **/
  public function getSupplierMatch($invoice)
  {
    if($Supplier = $this->matchName($invoice->getSupplierName(),$invoice->getCompany()->getId()))
    {
      return $Supplier;
    }

    return new Supplier();
  }
  
  /**
   * method for ajax request
   *
   * @return array
   * @author Enrique Martinez
   **/
  public function retrieveForSelect($q, $limit)
  {
    $items = $this->createQuery()
      ->where('name_slug LIKE ?', '%'.SupplierTable::slugify($q).'%')
      ->AndWhere('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))
      ->limit($limit)
      ->execute();
    
    $res = array();
    $i = 0;
    foreach ($items as $item)
    {
      $res[$i]['id'] = $item->getId();
      $res[$i]['supplier'] = $item->getName();
      $res[$i]['business_name'] = $item->getBusinessName();
      $res[$i]['identification'] = $item->getIdentification();
      $res[$i]['phone'] = $item->getPhone();
      $res[$i]['fax'] = $item->getFax();
      $res[$i]['mobile'] = $item->getMobile();
      $res[$i]['email'] = $item->getEmail();
      $res[$i]['contact_person'] = $item->getContactPerson();
      $res[$i]['contact_person_phone'] = $item->getContactPersonPhone();
      $res[$i]['contact_person_email'] = $item->getContactPersonEmail();
      $res[$i]['invoicing_address'] = $item->getInvoicingAddress();
      $res[$i]['invoicing_city'] = $item->getInvoicingCity();
      $res[$i]['invoicing_state'] = $item->getInvoicingState();
      $res[$i]['invoicing_postalcode'] = $item->getInvoicingPostalcode();
      $res[$i]['invoicing_country'] = $item->getInvoicingCountry();
      $res[$i]['comments'] = $item->getComments();
      $res[$i]['tax_condition'] = $item->getTaxCondition()->getName();  
      $res[$i]['payment_type'] = $item->getPaymentType()->getId();
      $res[$i]['expense_type'] = $item->getExpenseType()->getId();

      $i++;
    }
    
    return $res;
  }
  
  /**
   * method for ajax request
   * This is for the search form
   *
   * @return array
   * @author Enrique Martinez
   **/
  public function simpleRetrieveForSelect($q, $limit)
  {
    $items = Doctrine::getTable('Supplier')->createQuery()
      ->where('name_slug LIKE ?', '%'.SupplierTable::slugify($q).'%')
      ->AndWhere('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))
      ->limit($limit)
      ->execute();
    
    $res = array();
    foreach ($items as $item)
    {
      $res[$item->getId()] = $item->getName();
    }
    
    return $res;
  }
  
  public function getNonDraftInvoices($supplier_id,$date_range = array()) {

    $search = array_merge(array('supplier_id'=>$supplier_id),$date_range);
    $q = ExpenseQuery::create()->search($search)->andWhere('i.draft = 0');
    return $q->execute();
  }
  
  public static function getSupplierName($Supplier_id = null)
  {
    if ($Supplier_id)
    {
      $Supplier = Doctrine::getTable('Supplier')->findOneById($Supplier_id);
      if ($Supplier)
      {
        return $Supplier->getName();
      }
    }

    return '';
  }
  
  /**
   * Rebuild the name slug for each Supplier in database.
   */
  public static function rebuildSlugs()
  {
    $total = 0;
    $Suppliers = Doctrine::getTable('Supplier')->createQuery()->execute();
    foreach ($Suppliers as $Supplier)
    {
      $Supplier->setNameSlug(SupplierTable::slugify($Supplier->getName()));
      $Supplier->save();
      $total++;
    }
    return $total;
  }

}
