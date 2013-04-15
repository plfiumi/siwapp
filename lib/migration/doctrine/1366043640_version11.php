<?php

class Version11 extends Doctrine_Migration_Base
{
  public function up()
  {
        $this->addColumn('common','remesed','boolean', array('default' => 'false'));
  }

  public function down()
  {
        $this->removeColumn('common','remesed');
  }
}
