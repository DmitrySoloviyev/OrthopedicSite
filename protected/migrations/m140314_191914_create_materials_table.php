<?php

class m140314_191914_create_materials_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('materials', [
            'id' => 'pk',
            'title' => 'varchar(100) not null',
            'is_deleted' => 'boolean not null default 0'
        ], 'engine=innodb default charset=utf8');

        $this->insertMultiple('materials', [
            ['title' => 'К/П'],
            ['title' => 'Траспира'],
            ['title' => 'Мех Натуральный'],
            ['title' => 'Мех Искусственный'],
            ['title' => 'Мех Полушерстяной'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('materials');
    }

}
