<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CustomerTable extends Doctrine_Table
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
   * checks if there is a match in customer name
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
   * Updates a Customer object matching the object's data.
   *
   * @return void
   * @author Carlos Escribano <carlos@markhaus.com>
   **/
  public function updateCustomer($obj)
  {
    $customer = $this->getCustomerMatch($obj);
    if($customer->isNew())
    {
      $customer->setDataFrom($obj);
    }
    $obj->setCustomer($customer);
    $customer->save();
  }

  /**
   * gets the customer that matches the invoice data
   * If no match returns a new Customer object
   *
   * @param Invoice|RecurringInvoice -- the invoice or the recurring one.
   * @return Customer  -- the customer matched
   * @author Enrique Martinez
   **/
  public function getCustomerMatch($invoice)
  {
    if($customer = $this->matchName($invoice->getCustomerName(),$invoice->getCompany()->getId()))
    {
      return $customer;
    }

    return new Customer();
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
    ->where('name_slug LIKE ?', '%'.CustomerTable::slugify($q).'%')
      ->AndWhere('company_id = ?', sfContext::getInstance()->getUser()->getAttribute('company_id'))
      ->limit($limit)
      ->execute();

    $res = array();
    $i = 0;
    foreach ($items as $item)
    {
      $res[$i]['id'] = $item->getId();
      $res[$i]['customer'] = $item->getName();
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
      $res[$i]['shipping_address'] = $item->getShippingAddress();
      $res[$i]['shipping_city'] = $item->getShippingCity();
      $res[$i]['shipping_state'] = $item->getShippingState();
      $res[$i]['shipping_postalcode'] = $item->getShippingPostalcode();
      $res[$i]['shipping_country'] = $item->getShippingCountry();
      $res[$i]['shipping_company_data'] = $item->getShippingCompanyData();
      $res[$i]['comments'] = $item->getComments();
      $res[$i]['tax_condition'] = $item->getTaxCondition()->getName();  
      $res[$i]['payment_type'] = $item->getPaymentType()->getId();
      $res[$i]['discount'] = $item->getDiscount();
      $res[$i]['series'] = $item->getSeries()->getId();

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
    $items = Doctrine::getTable('Customer')->createQuery()
      ->where('name_slug LIKE ?', '%'.CustomerTable::slugify($q).'%')
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

  public function getNonDraftInvoices($customer_id,$date_range = array()) {

    $search = array_merge(array('customer_id'=>$customer_id),$date_range);
    $q = InvoiceQuery::create()->search($search)->andWhere('i.draft = 0');
    return $q->execute();
  }

  public static function getCustomerName($customer_id = null)
  {
    if ($customer_id)
    {
      $customer = Doctrine::getTable('Customer')->findOneById($customer_id);
      if ($customer)
      {
        return $customer->getName();
      }
    }

    return '';
  }

  /**
   * Rebuild the name slug for each Customer in database.
   */
  public static function rebuildSlugs()
  {
    $total = 0;
    $customers = Doctrine::getTable('Customer')->createQuery()->execute();
    foreach ($customers as $customer)
    {
      $customer->setNameSlug(CustomerTable::slugify($customer->getName()));
      $customer->save();
      $total++;
    }
    return $total;
  }

}
