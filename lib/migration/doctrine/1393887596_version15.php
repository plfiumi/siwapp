<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version15 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('company', 'bic');
        $this->removeColumn('company', 'iban');
        $this->removeColumn('company', 'entity');
        $this->removeColumn('company', 'office');
        $this->removeColumn('company', 'control_digit');
        $this->removeColumn('company', 'account');
        $this->removeColumn('customer', 'bic');
        $this->removeColumn('customer', 'iban');
        $this->removeColumn('customer', 'entity');
        $this->removeColumn('customer', 'office');
        $this->removeColumn('customer', 'control_digit');
        $this->removeColumn('customer', 'account');
        $this->addColumn('common', 'contact_person_phone', 'string', '20', array(
             ));
        $this->addColumn('common', 'contact_person_email', 'string', '100', array(
             ));
        $this->addColumn('common', 'shipping_address', 'string', '255', array(
             ));
        $this->addColumn('common', 'days_to_due', 'integer', '3', array(
             ));
        $this->addColumn('common', 'enabled', 'boolean', '25', array(
             'default' => '0',
             ));
        $this->addColumn('common', 'max_occurrences', 'integer', '4', array(
             ));
        $this->addColumn('common', 'period', 'integer', '4', array(
             ));
        $this->addColumn('common', 'period_type', 'string', '8', array(
             ));
        $this->addColumn('common', 'starting_date', 'date', '25', array(
             ));
        $this->addColumn('common', 'finishing_date', 'date', '25', array(
             ));
        $this->addColumn('common', 'draft', 'boolean', '25', array(
             'default' => '1',
             ));
        $this->addColumn('common', 'sent_by_email', 'boolean', '25', array(
             'default' => '0',
             ));
        $this->addColumn('common', 'number', 'integer', '4', array(
             ));
        $this->addColumn('common', 'recurring_invoice_id', 'integer', '8', array(
             ));
        $this->addColumn('common', 'issue_date', 'date', '25', array(
             ));
        $this->addColumn('common', 'due_date', 'date', '25', array(
             ));
        $this->addColumn('company', 'financial_entity', 'string', '50', array(
             ));
        $this->addColumn('company', 'financial_entity_office', 'string', '50', array(
             ));
        $this->addColumn('company', 'financial_entity_control_digit', 'string', '50', array(
             ));
        $this->addColumn('company', 'financial_entity_account', 'string', '50', array(
             ));
        $this->addColumn('company', 'financial_entity_bic', 'string', '50', array(
             ));
        $this->addColumn('company', 'financial_entity_iban', 'string', '50', array(
             ));
        $this->addColumn('customer', 'business_name', 'string', '100', array(
             ));
        $this->addColumn('customer', 'shipping_company_data', 'clob', '', array(
             ));
        $this->addColumn('customer', 'contact_person_phone', 'string', '20', array(
             ));
        $this->addColumn('customer', 'contact_person_email', 'string', '100', array(
             ));
        $this->addColumn('customer', 'invoicing_serie', 'string', '10', array(
             ));
        $this->addColumn('customer', 'tax_condition', 'string', '10', array(
             ));
        $this->addColumn('customer', 'financial_entity', 'string', '50', array(
             ));
        $this->addColumn('customer', 'financial_entity_office', 'string', '50', array(
             ));
        $this->addColumn('customer', 'financial_entity_control_digit', 'string', '50', array(
             ));
        $this->addColumn('customer', 'financial_entity_account', 'string', '50', array(
             ));
        $this->addColumn('customer', 'financial_entity_bic', 'string', '50', array(
             ));
        $this->addColumn('customer', 'financial_entity_iban', 'string', '50', array(
             ));
        $this->changeColumn('customer', 'name_slug', 'string', '120', array(
             ));
    }

    public function down()
    {
        $this->addColumn('company', 'bic', 'string', '50', array(
             ));
        $this->addColumn('company', 'iban', 'string', '50', array(
             ));
        $this->addColumn('company', 'entity', 'string', '50', array(
             ));
        $this->addColumn('company', 'office', 'string', '50', array(
             ));
        $this->addColumn('company', 'control_digit', 'string', '50', array(
             ));
        $this->addColumn('company', 'account', 'string', '50', array(
             ));
        $this->addColumn('customer', 'bic', 'string', '50', array(
             ));
        $this->addColumn('customer', 'iban', 'string', '50', array(
             ));
        $this->addColumn('customer', 'entity', 'string', '50', array(
             ));
        $this->addColumn('customer', 'office', 'string', '50', array(
             ));
        $this->addColumn('customer', 'control_digit', 'string', '50', array(
             ));
        $this->addColumn('customer', 'account', 'string', '50', array(
             ));
        $this->removeColumn('common', 'contact_person_phone');
        $this->removeColumn('common', 'contact_person_email');
        $this->removeColumn('common', 'shipping_address');
        $this->removeColumn('common', 'days_to_due');
        $this->removeColumn('common', 'enabled');
        $this->removeColumn('common', 'max_occurrences');
        $this->removeColumn('common', 'period');
        $this->removeColumn('common', 'period_type');
        $this->removeColumn('common', 'starting_date');
        $this->removeColumn('common', 'finishing_date');
        $this->removeColumn('common', 'draft');
        $this->removeColumn('common', 'sent_by_email');
        $this->removeColumn('common', 'number');
        $this->removeColumn('common', 'recurring_invoice_id');
        $this->removeColumn('common', 'issue_date');
        $this->removeColumn('common', 'due_date');
        $this->removeColumn('company', 'financial_entity');
        $this->removeColumn('company', 'financial_entity_office');
        $this->removeColumn('company', 'financial_entity_control_digit');
        $this->removeColumn('company', 'financial_entity_account');
        $this->removeColumn('company', 'financial_entity_bic');
        $this->removeColumn('company', 'financial_entity_iban');
        $this->removeColumn('customer', 'business_name');
        $this->removeColumn('customer', 'shipping_company_data');
        $this->removeColumn('customer', 'contact_person_phone');
        $this->removeColumn('customer', 'contact_person_email');
        $this->removeColumn('customer', 'invoicing_serie');
        $this->removeColumn('customer', 'tax_condition');
        $this->removeColumn('customer', 'financial_entity');
        $this->removeColumn('customer', 'financial_entity_office');
        $this->removeColumn('customer', 'financial_entity_control_digit');
        $this->removeColumn('customer', 'financial_entity_account');
        $this->removeColumn('customer', 'financial_entity_bic');
        $this->removeColumn('customer', 'financial_entity_iban');
    }
}