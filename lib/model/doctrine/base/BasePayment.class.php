<?php

/**
 * BasePayment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $company_id
 * @property integer $invoice_id
 * @property date $date
 * @property decimal $amount
 * @property clob $notes
 * @property Company $Company
 * @property Common $Common
 * 
 * @method integer getCompanyId()  Returns the current record's "company_id" value
 * @method integer getInvoiceId()  Returns the current record's "invoice_id" value
 * @method date    getDate()       Returns the current record's "date" value
 * @method decimal getAmount()     Returns the current record's "amount" value
 * @method clob    getNotes()      Returns the current record's "notes" value
 * @method Company getCompany()    Returns the current record's "Company" value
 * @method Common  getCommon()     Returns the current record's "Common" value
 * @method Payment setCompanyId()  Sets the current record's "company_id" value
 * @method Payment setInvoiceId()  Sets the current record's "invoice_id" value
 * @method Payment setDate()       Sets the current record's "date" value
 * @method Payment setAmount()     Sets the current record's "amount" value
 * @method Payment setNotes()      Sets the current record's "notes" value
 * @method Payment setCompany()    Sets the current record's "Company" value
 * @method Payment setCommon()     Sets the current record's "Common" value
 * 
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePayment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('payment');
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('invoice_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('amount', 'decimal', 53, array(
             'type' => 'decimal',
             'scale' => 15,
             'length' => 53,
             ));
        $this->hasColumn('notes', 'clob', null, array(
             'type' => 'clob',
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

        $this->hasOne('Common', array(
             'local' => 'invoice_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));
    }
}