<?php


class EstimateTable extends CommonTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Estimate');
    }
    
    public function getNextNumber($series_id)
    {
    $company_id=sfContext::getInstance()->getUser()->getAttribute('company_id');
    
      $found = $this->createQuery()
        ->where('Draft = ?', 0)
        ->AndWhere('company_id = ?',$company_id )
        ->execute()
        ->count();

      if ($found > 0)
      {
        $rs = $this->createQuery()
          ->select('MAX(number) AS max_number')
          ->AndWhere('company_id = ?',$company_id )
          ->where('Draft = ?', 0)
          ->fetchOne();
        return intval($rs->getMaxNumber()) + 1;
      }
      else
      {
        return 1;
      }
    }
}
