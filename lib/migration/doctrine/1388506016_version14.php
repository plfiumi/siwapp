<?php

class Version14 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('company', 'bic', 'varchar', '50', array());
    $this->addColumn('customer', 'bic', 'varchar', '50', array());
    $this->addColumn('customer', 'discount', 'decimal', '53', array());
    $this->addColumn('common', 'discount', 'decimal', '53', array());
  }

  public function down()
  {
    $this->removeColumn('company', 'bic');
    $this->removeColumn('customer', 'bic');
    $this->removeColumn('customer', 'discount');
    $this->removeColumn('common', 'discount');
  }
}
