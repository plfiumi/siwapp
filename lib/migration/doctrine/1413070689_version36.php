<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version36 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('common', 'customer_tax_condition', 'string', '255', array(
             ));
        $this->changeColumn('common', 'supplier_tax_condition', 'string', '255', array(
             ));
    }

    public function down()
    {
    }
}