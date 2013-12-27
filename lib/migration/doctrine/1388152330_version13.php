<?php

class Version13 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('tag', 'company_id', 'integer', '8', array(
         ));
    $this->createForeignKey('tag', 'tag_company_id_company_id', array(
         'name' => 'tag_company_id_company_id',
         'local' => 'company_id',
         'foreign' => 'id',
         'foreignTable' => 'company',
         'onUpdate' => '',
         'onDelete' => 'CASCADE',
         ));
    $this->addIndex('tag', 'company_id', array(
         'fields' =>
         array(
          0 => 'company_id',
         ),
         ));
  }

  public function down()
  {
        $this->dropForeignKey('tag', 'tag_company_id_company_id');
        $this->removeIndex('tag', 'company_id', array(
             'fields' =>
             array(
              0 => 'company_id',
             ),
             ));
        $this->removeColumn('tag', 'company_id');
  }
}
