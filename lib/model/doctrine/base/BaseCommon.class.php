<?php

/**
 * BaseCommon
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $company_id
 * @property integer $series_id
 * @property integer $customer_id
 * @property string $customer_name
 * @property string $customer_identification
 * @property string $customer_email
 * @property string $customer_phone
 * @property string $customer_fax
 * @property integer $supplier_id
 * @property string $supplier_name
 * @property string $supplier_identification
 * @property string $supplier_email
 * @property string $supplier_phone
 * @property string $supplier_fax
 * @property clob $invoicing_address
 * @property clob $shipping_address
 * @property string $contact_person
 * @property clob $terms
 * @property clob $notes
 * @property decimal $base_amount
 * @property decimal $discount_amount
 * @property decimal $net_amount
 * @property decimal $gross_amount
 * @property decimal $paid_amount
 * @property decimal $tax_amount
 * @property integer $status
 * @property integer $payment_type_id
 * @property string $type
 * @property boolean $draft
 * @property boolean $closed
 * @property boolean $sent_by_email
 * @property integer $number
 * @property integer $recurring_invoice_id
 * @property integer $estimate_id
 * @property date $issue_date
 * @property date $due_date
 * @property string $supplier_reference
 * @property integer $days_to_due
 * @property boolean $enabled
 * @property integer $max_occurrences
 * @property integer $must_occurrences
 * @property integer $period
 * @property string $period_type
 * @property date $starting_date
 * @property date $finishing_date
 * @property date $last_execution_date
 * @property Company $Company
 * @property Customer $Customer
 * @property Supplier $Supplier
 * @property Series $Series
 * @property PaymentType $PaymentType
 * @property Doctrine_Collection $Items
 * @property Doctrine_Collection $Payments
 * 
 * @method integer             getCompanyId()               Returns the current record's "company_id" value
 * @method integer             getSeriesId()                Returns the current record's "series_id" value
 * @method integer             getCustomerId()              Returns the current record's "customer_id" value
 * @method string              getCustomerName()            Returns the current record's "customer_name" value
 * @method string              getCustomerIdentification()  Returns the current record's "customer_identification" value
 * @method string              getCustomerEmail()           Returns the current record's "customer_email" value
 * @method string              getCustomerPhone()           Returns the current record's "customer_phone" value
 * @method string              getCustomerFax()             Returns the current record's "customer_fax" value
 * @method integer             getSupplierId()              Returns the current record's "supplier_id" value
 * @method string              getSupplierName()            Returns the current record's "supplier_name" value
 * @method string              getSupplierIdentification()  Returns the current record's "supplier_identification" value
 * @method string              getSupplierEmail()           Returns the current record's "supplier_email" value
 * @method string              getSupplierPhone()           Returns the current record's "supplier_phone" value
 * @method string              getSupplierFax()             Returns the current record's "supplier_fax" value
 * @method clob                getInvoicingAddress()        Returns the current record's "invoicing_address" value
 * @method clob                getShippingAddress()         Returns the current record's "shipping_address" value
 * @method string              getContactPerson()           Returns the current record's "contact_person" value
 * @method clob                getTerms()                   Returns the current record's "terms" value
 * @method clob                getNotes()                   Returns the current record's "notes" value
 * @method decimal             getBaseAmount()              Returns the current record's "base_amount" value
 * @method decimal             getDiscountAmount()          Returns the current record's "discount_amount" value
 * @method decimal             getNetAmount()               Returns the current record's "net_amount" value
 * @method decimal             getGrossAmount()             Returns the current record's "gross_amount" value
 * @method decimal             getPaidAmount()              Returns the current record's "paid_amount" value
 * @method decimal             getTaxAmount()               Returns the current record's "tax_amount" value
 * @method integer             getStatus()                  Returns the current record's "status" value
 * @method integer             getPaymentTypeId()           Returns the current record's "payment_type_id" value
 * @method string              getType()                    Returns the current record's "type" value
 * @method boolean             getDraft()                   Returns the current record's "draft" value
 * @method boolean             getClosed()                  Returns the current record's "closed" value
 * @method boolean             getSentByEmail()             Returns the current record's "sent_by_email" value
 * @method integer             getNumber()                  Returns the current record's "number" value
 * @method integer             getRecurringInvoiceId()      Returns the current record's "recurring_invoice_id" value
 * @method integer             getEstimateId()              Returns the current record's "estimate_id" value
 * @method date                getIssueDate()               Returns the current record's "issue_date" value
 * @method date                getDueDate()                 Returns the current record's "due_date" value
 * @method string              getSupplierReference()       Returns the current record's "supplier_reference" value
 * @method integer             getDaysToDue()               Returns the current record's "days_to_due" value
 * @method boolean             getEnabled()                 Returns the current record's "enabled" value
 * @method integer             getMaxOccurrences()          Returns the current record's "max_occurrences" value
 * @method integer             getMustOccurrences()         Returns the current record's "must_occurrences" value
 * @method integer             getPeriod()                  Returns the current record's "period" value
 * @method string              getPeriodType()              Returns the current record's "period_type" value
 * @method date                getStartingDate()            Returns the current record's "starting_date" value
 * @method date                getFinishingDate()           Returns the current record's "finishing_date" value
 * @method date                getLastExecutionDate()       Returns the current record's "last_execution_date" value
 * @method Company             getCompany()                 Returns the current record's "Company" value
 * @method Customer            getCustomer()                Returns the current record's "Customer" value
 * @method Supplier            getSupplier()                Returns the current record's "Supplier" value
 * @method Series              getSeries()                  Returns the current record's "Series" value
 * @method PaymentType         getPaymentType()             Returns the current record's "PaymentType" value
 * @method Doctrine_Collection getItems()                   Returns the current record's "Items" collection
 * @method Doctrine_Collection getPayments()                Returns the current record's "Payments" collection
 * @method Common              setCompanyId()               Sets the current record's "company_id" value
 * @method Common              setSeriesId()                Sets the current record's "series_id" value
 * @method Common              setCustomerId()              Sets the current record's "customer_id" value
 * @method Common              setCustomerName()            Sets the current record's "customer_name" value
 * @method Common              setCustomerIdentification()  Sets the current record's "customer_identification" value
 * @method Common              setCustomerEmail()           Sets the current record's "customer_email" value
 * @method Common              setCustomerPhone()           Sets the current record's "customer_phone" value
 * @method Common              setCustomerFax()             Sets the current record's "customer_fax" value
 * @method Common              setSupplierId()              Sets the current record's "supplier_id" value
 * @method Common              setSupplierName()            Sets the current record's "supplier_name" value
 * @method Common              setSupplierIdentification()  Sets the current record's "supplier_identification" value
 * @method Common              setSupplierEmail()           Sets the current record's "supplier_email" value
 * @method Common              setSupplierPhone()           Sets the current record's "supplier_phone" value
 * @method Common              setSupplierFax()             Sets the current record's "supplier_fax" value
 * @method Common              setInvoicingAddress()        Sets the current record's "invoicing_address" value
 * @method Common              setShippingAddress()         Sets the current record's "shipping_address" value
 * @method Common              setContactPerson()           Sets the current record's "contact_person" value
 * @method Common              setTerms()                   Sets the current record's "terms" value
 * @method Common              setNotes()                   Sets the current record's "notes" value
 * @method Common              setBaseAmount()              Sets the current record's "base_amount" value
 * @method Common              setDiscountAmount()          Sets the current record's "discount_amount" value
 * @method Common              setNetAmount()               Sets the current record's "net_amount" value
 * @method Common              setGrossAmount()             Sets the current record's "gross_amount" value
 * @method Common              setPaidAmount()              Sets the current record's "paid_amount" value
 * @method Common              setTaxAmount()               Sets the current record's "tax_amount" value
 * @method Common              setStatus()                  Sets the current record's "status" value
 * @method Common              setPaymentTypeId()           Sets the current record's "payment_type_id" value
 * @method Common              setType()                    Sets the current record's "type" value
 * @method Common              setDraft()                   Sets the current record's "draft" value
 * @method Common              setClosed()                  Sets the current record's "closed" value
 * @method Common              setSentByEmail()             Sets the current record's "sent_by_email" value
 * @method Common              setNumber()                  Sets the current record's "number" value
 * @method Common              setRecurringInvoiceId()      Sets the current record's "recurring_invoice_id" value
 * @method Common              setEstimateId()              Sets the current record's "estimate_id" value
 * @method Common              setIssueDate()               Sets the current record's "issue_date" value
 * @method Common              setDueDate()                 Sets the current record's "due_date" value
 * @method Common              setSupplierReference()       Sets the current record's "supplier_reference" value
 * @method Common              setDaysToDue()               Sets the current record's "days_to_due" value
 * @method Common              setEnabled()                 Sets the current record's "enabled" value
 * @method Common              setMaxOccurrences()          Sets the current record's "max_occurrences" value
 * @method Common              setMustOccurrences()         Sets the current record's "must_occurrences" value
 * @method Common              setPeriod()                  Sets the current record's "period" value
 * @method Common              setPeriodType()              Sets the current record's "period_type" value
 * @method Common              setStartingDate()            Sets the current record's "starting_date" value
 * @method Common              setFinishingDate()           Sets the current record's "finishing_date" value
 * @method Common              setLastExecutionDate()       Sets the current record's "last_execution_date" value
 * @method Common              setCompany()                 Sets the current record's "Company" value
 * @method Common              setCustomer()                Sets the current record's "Customer" value
 * @method Common              setSupplier()                Sets the current record's "Supplier" value
 * @method Common              setSeries()                  Sets the current record's "Series" value
 * @method Common              setPaymentType()             Sets the current record's "PaymentType" value
 * @method Common              setItems()                   Sets the current record's "Items" collection
 * @method Common              setPayments()                Sets the current record's "Payments" collection
 * 
 * @package    siwapp
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCommon extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('common');
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('series_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('customer_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('customer_name', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('customer_identification', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('customer_email', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('customer_phone', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('customer_fax', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('supplier_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('supplier_name', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('supplier_identification', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('supplier_email', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('supplier_phone', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('supplier_fax', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('invoicing_address', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('shipping_address', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('contact_person', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('terms', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('notes', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('base_amount', 'decimal', 53, array(
             'type' => 'decimal',
             'scale' => 15,
             'length' => 53,
             ));
        $this->hasColumn('discount_amount', 'decimal', 53, array(
             'type' => 'decimal',
             'scale' => 15,
             'length' => 53,
             ));
        $this->hasColumn('net_amount', 'decimal', 53, array(
             'type' => 'decimal',
             'scale' => 15,
             'length' => 53,
             ));
        $this->hasColumn('gross_amount', 'decimal', 53, array(
             'type' => 'decimal',
             'scale' => 15,
             'length' => 53,
             ));
        $this->hasColumn('paid_amount', 'decimal', 53, array(
             'type' => 'decimal',
             'scale' => 15,
             'length' => 53,
             ));
        $this->hasColumn('tax_amount', 'decimal', 53, array(
             'type' => 'decimal',
             'scale' => 15,
             'length' => 53,
             ));
        $this->hasColumn('status', 'integer', 1, array(
             'type' => 'integer',
             'length' => 1,
             ));
        $this->hasColumn('payment_type_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('type', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('draft', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('closed', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('sent_by_email', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('number', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('recurring_invoice_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('estimate_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('issue_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('due_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('supplier_reference', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('days_to_due', 'integer', 3, array(
             'type' => 'integer',
             'length' => 3,
             ));
        $this->hasColumn('enabled', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('max_occurrences', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('must_occurrences', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('period', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('period_type', 'string', 8, array(
             'type' => 'string',
             'length' => 8,
             ));
        $this->hasColumn('starting_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('finishing_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('last_execution_date', 'date', null, array(
             'type' => 'date',
             ));


        $this->index('compny', array(
             'fields' => 
             array(
              0 => 'company_id',
             ),
             ));
        $this->index('cstnm', array(
             'fields' => 
             array(
              0 => 'company_id',
              1 => 'customer_name',
             ),
             ));
        $this->index('cstid', array(
             'fields' => 
             array(
              0 => 'company_id',
              1 => 'customer_identification',
             ),
             ));
        $this->index('cstml', array(
             'fields' => 
             array(
              0 => 'company_id',
              1 => 'customer_email',
             ),
             ));
        $this->index('cntct', array(
             'fields' => 
             array(
              0 => 'company_id',
              1 => 'contact_person',
             ),
             ));
        $this->option('charset', 'utf8');

        $this->setSubClasses(array(
             'Invoice' => 
             array(
              'type' => 'Invoice',
             ),
             'Expense' => 
             array(
              'type' => 'Expense',
             ),
             'Estimate' => 
             array(
              'type' => 'Estimate',
             ),
             'RecurringInvoice' => 
             array(
              'type' => 'RecurringInvoice',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Company', array(
             'local' => 'company_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Customer', array(
             'local' => 'customer_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasOne('Supplier', array(
             'local' => 'supplier_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasOne('Series', array(
             'local' => 'series_id',
             'foreign' => 'id',
             'onDelete' => 'set null'));

        $this->hasOne('PaymentType', array(
             'local' => 'payment_type_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasMany('Item as Items', array(
             'local' => 'id',
             'foreign' => 'common_id'));

        $this->hasMany('Payment as Payments', array(
             'local' => 'id',
             'foreign' => 'invoice_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $taggable0 = new Taggable();
        $this->actAs($timestampable0);
        $this->actAs($taggable0);
    }
}