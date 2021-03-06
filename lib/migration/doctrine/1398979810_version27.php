<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version27 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('supplier', 'business_name', 'string', '100', array(
             ));
        $this->addColumn('supplier', 'contact_person_phone', 'string', '20', array(
             ));
        $this->addColumn('supplier', 'contact_person_email', 'string', '100', array(
             ));
        $this->addColumn('supplier', 'tax_condition', 'string', '10', array(
             ));
        $this->addColumn('supplier', 'financial_entity', 'string', '50', array(
             ));
        $this->addColumn('supplier', 'financial_entity_office', 'string', '50', array(
             ));
        $this->addColumn('supplier', 'financial_entity_account', 'string', '50', array(
             ));
        $this->addColumn('supplier', 'payment_type_id', 'integer', '8', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('supplier', 'business_name');
        $this->removeColumn('supplier', 'contact_person_phone');
        $this->removeColumn('supplier', 'contact_person_email');
        $this->removeColumn('supplier', 'tax_condition');
        $this->removeColumn('supplier', 'financial_entity');
        $this->removeColumn('supplier', 'financial_entity_office');
        $this->removeColumn('supplier', 'financial_entity_account');
        $this->removeColumn('supplier', 'payment_type_id');
    }
}