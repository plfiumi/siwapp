<?php

class UserQuery extends Doctrine_Query
{
  public static function create($conn = null, $class = null)
  {
    $q = new UserQuery($conn);

      
    $q->from("Profile p")
      ->innerJoin("p.User u")
      ->orderBy('p.last_name asc')
      ->groupBy('u.id');
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
      $this->addWhere("p.first_name LIKE '%$text%' or p.last_name LIKE '%$text%'");

    }
    return $this;
  }
  
}
