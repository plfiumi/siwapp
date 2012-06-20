<?php

/**
 * BaseExpenseType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property boolean $enabled
 * @property Doctrine_Collection $Supplier
 * 
 * @method string              getName()     Returns the current record's "name" value
 * @method boolean             getEnabled()  Returns the current record's "enabled" value
 * @method Doctrine_Collection getSupplier() Returns the current record's "Supplier" collection
 * @method ExpenseType         setName()     Sets the current record's "name" value
 * @method ExpenseType         setEnabled()  Sets the current record's "enabled" value
 * @method ExpenseType         setSupplier() Sets the current record's "Supplier" collection
 * 
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseExpenseType extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('expense_type');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('enabled', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));

        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Supplier', array(
             'local' => 'id',
             'foreign' => 'expense_type_id'));
    }
}