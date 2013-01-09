<?php

class Version9 extends Doctrine_Migration_Base
{
  public function up()
  {
      $this->addColumn('company', 'suffix', 'string', '255', array( ));
  }

  public function down()
  {
      $this->removeColumn('company', 'suffix');
  }
}
