<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version35 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('common', 'supplier_tax_condition', 'string', '10', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('common', 'supplier_tax_condition');
    }
}