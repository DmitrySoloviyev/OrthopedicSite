<?php

class m140314_191914_create_materials_table extends CDbMigration
{
    public function safeUp()
    {
        $this->execute('ALTER DATABASE `ortho_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        $this->createTable('materials', [
            'id' => 'pk',
            'title' => 'varchar(100) not null',
            'is_deleted' => 'boolean not null default 0'
        ], 'engine=innodb default charset=utf8mb4');

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
