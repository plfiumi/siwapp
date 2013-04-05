<?php

class Version10 extends Doctrine_Migration_Base
{
  public function up()
  {
      $this->addColumn('company','fiscality','boolean',array('default' => false));
  }

  public function down()
  {
      $this->removeColumn('company','fiscality');
  }
}
