<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version33 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('common', 'supplier_business_name', 'string', '100', array(
             ));
        $this->addColumn('common', 'supplier_mobile', 'string', '20', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('common', 'supplier_business_name');
        $this->removeColumn('common', 'supplier_mobile');
    }
}