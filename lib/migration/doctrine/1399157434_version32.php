<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version32 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('customer', 'customer_tax_condition_id_tax_condition_id', array(
             'name' => 'customer_tax_condition_id_tax_condition_id',
             'local' => 'tax_condition_id',
             'foreign' => 'id',
             'foreignTable' => 'tax_condition',
             'onUpdate' => '',
             'onDelete' => 'set null',
             ));
        $this->createForeignKey('supplier', 'supplier_tax_condition_id_tax_condition_id', array(
             'name' => 'supplier_tax_condition_id_tax_condition_id',
             'local' => 'tax_condition_id',
             'foreign' => 'id',
             'foreignTable' => 'tax_condition',
             'onUpdate' => '',
             'onDelete' => 'set null',
             ));
        $this->addIndex('customer', 'customer_tax_condition_id', array(
             'fields' => 
             array(
              0 => 'tax_condition_id',
             ),
             ));
        $this->addIndex('supplier', 'supplier_tax_condition_id', array(
             'fields' => 
             array(
              0 => 'tax_condition_id',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('customer', 'customer_tax_condition_id_tax_condition_id');
        $this->dropForeignKey('supplier', 'supplier_tax_condition_id_tax_condition_id');
        $this->removeIndex('customer', 'customer_tax_condition_id', array(
             'fields' => 
             array(
              0 => 'tax_condition_id',
             ),
             ));
        $this->removeIndex('supplier', 'supplier_tax_condition_id', array(
             'fields' => 
             array(
              0 => 'tax_condition_id',
             ),
             ));
    }
}