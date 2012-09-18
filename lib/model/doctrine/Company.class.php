<?php

/**
 * Company
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Company extends BaseCompany
{
  public function getDefaultCompany($userid)
  {
    $company = $this->getTable()->createQuery('c')
                 ->where('exists (select company_id from company_user cu where c.id = cu.company_id and cu.sf_guard_user_id = ?) ', $userid)
                 ->fetchOne();
    return $company;
  }
  
  public function loadById($company_id)
  {
      $company = $this->getTable()->createQuery('c')
                 ->where('c.id = ?',$company_id)
                 ->fetchOne();
    return $company;

  
  }
}
