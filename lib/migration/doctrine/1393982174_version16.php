<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version16 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('customer', 'invoicing_serie');
        $this->addColumn('customer', 'invoicing_series', 'string', '10', array(
             ));
    }

    public function down()
    {
        $this->addColumn('customer', 'invoicing_serie', 'string', '10', array(
             ));
        $this->removeColumn('customer', 'invoicing_series');
    }
}