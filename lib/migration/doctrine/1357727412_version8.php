<?php

class Version8 extends Doctrine_Migration_Base
{
  public function up()
  {
      $this->addColumn('company', 'iban', 'string', '50', array( ));
      $this->addColumn('company', 'entity', 'string', '50', array( ));
      $this->addColumn('company', 'office', 'string', '50', array( ));
      $this->addColumn('company', 'control_digit', 'string', '50', array( ));
      $this->addColumn('company', 'account', 'string', '50', array( ));
      $this->addColumn('company', 'mercantil_registry', 'string', '255', array( ));
  }

  public function down()
  {
      $this->removeColumn('company', 'iban');
      $this->removeColumn('company', 'entity');
      $this->removeColumn('company', 'office');
      $this->removeColumn('company', 'control_digit');
      $this->removeColumn('company', 'account');
      $this->removeColumn('company', 'mercantil_registry');
  }
}
