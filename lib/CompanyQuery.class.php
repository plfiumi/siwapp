<?php

class CompanyQuery extends Doctrine_Query
{
  public static function create($conn = null, $class = null)
  {
    $q = new CompanyQuery($conn);

      
    $q->from("Company c")
      ->orderBy('c.name asc')
      ->groupBy('c.id');
    //    echo $q->getSqlQuery();
    return $q;
  }

  public function getClone()
  {
    $other = clone($this);
    return $other;
  }

  public function search($search = null)
  {
    if($search)
    {
      if(isset($search['query']))  $this->textSearch($search['query']);
      //TODO MCY adding other query
    }
    return $this;
  }
  
  public function textSearch($text)
  {
    $text = trim($text);
    if($text)
    {
      //TODO MCY check if we could use a parameter instead
      $this
        ->addWhere("c.name LIKE '%$text%'");

    }
    return $this;
  }
  
}
