<?php

class m140314_191914_create_materials_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('materials', [
            'id' => 'pk',
            'title' => 'string not null',
            'created_by' => 'int not null',
            'modified_by' => 'int not null',
            'date_created' => 'datetime not null',
            'date_modified' => 'datetime not null',
            'is_deleted' => 'boolean not null default 0'
        ], 'engine=innodb default charset=utf8mb4');

        $this->addForeignKey('fk_materials_created_by_user', 'materials', 'created_by', 'users', 'id');
        $this->addForeignKey('fk_materials_modified_by_user', 'materials', 'modified_by', 'users', 'id');

        $this->insertMultiple('materials', [
            ['title' => 'К/П', 'created_by' => 1, 'modified_by' => 1, 'date_created' => new CDbExpression('NOW()'), 'date_modified' => new CDbExpression('NOW()')],
            ['title' => 'Траспира', 'created_by' => 1, 'modified_by' => 1, 'date_created' => new CDbExpression('NOW()'), 'date_modified' => new CDbExpression('NOW()')],
            ['title' => 'Мех Натуральный', 'created_by' => 1, 'modified_by' => 1, 'date_created' => new CDbExpression('NOW()'), 'date_modified' => new CDbExpression('NOW()')],
            ['title' => 'Мех Искусственный', 'created_by' => 1, 'modified_by' => 1, 'date_created' => new CDbExpression('NOW()'), 'date_modified' => new CDbExpression('NOW()')],
            ['title' => 'Мех Полушерстяной', 'created_by' => 1, 'modified_by' => 1, 'date_created' => new CDbExpression('NOW()'), 'date_modified' => new CDbExpression('NOW()')],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('materials');
    }

}
