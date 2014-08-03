<?php

class m140314_191914_create_materials_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('materials', [
            'id' => 'pk',
            'material_name' => 'varchar(30) not null',
            'is_deleted' => 'boolean not null default 0'
        ], 'engine=innodb default charset=utf8');

        $this->insertMultiple('materials', [
            ['material' => 'К/П'],
            ['material' => 'Траспира'],
            ['material' => 'Мех Натуральный'],
            ['material' => 'Мех Искусственный'],
            ['material' => 'Мех Полушерстяной'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('materials');
    }

}
