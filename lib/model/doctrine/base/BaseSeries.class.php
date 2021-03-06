<?php

/**
 * BaseSeries
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $company_id
 * @property string $name
 * @property string $value
 * @property integer $first_number
 * @property boolean $enabled
 * @property Company $Company
 * @property Doctrine_Collection $Series
 * @property Doctrine_Collection $Common
 * 
 * @method integer             getCompanyId()    Returns the current record's "company_id" value
 * @method string              getName()         Returns the current record's "name" value
 * @method string              getValue()        Returns the current record's "value" value
 * @method integer             getFirstNumber()  Returns the current record's "first_number" value
 * @method boolean             getEnabled()      Returns the current record's "enabled" value
 * @method Company             getCompany()      Returns the current record's "Company" value
 * @method Doctrine_Collection getSeries()       Returns the current record's "Series" collection
 * @method Doctrine_Collection getCommon()       Returns the current record's "Common" collection
 * @method Series              setCompanyId()    Sets the current record's "company_id" value
 * @method Series              setName()         Sets the current record's "name" value
 * @method Series              setValue()        Sets the current record's "value" value
 * @method Series              setFirstNumber()  Sets the current record's "first_number" value
 * @method Series              setEnabled()      Sets the current record's "enabled" value
 * @method Series              setCompany()      Sets the current record's "Company" value
 * @method Series              setSeries()       Sets the current record's "Series" collection
 * @method Series              setCommon()       Sets the current record's "Common" collection
 * 
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSeries extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('series');
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('value', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('first_number', 'integer', 4, array(
             'type' => 'integer',
             'default' => 1,
             'length' => 4,
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
        $this->hasOne('Company', array(
             'local' => 'company_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Customer as Series', array(
             'local' => 'id',
             'foreign' => 'series_id'));

        $this->hasMany('Common', array(
             'local' => 'id',
             'foreign' => 'series_id'));
    }
}