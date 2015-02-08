<?php

class m140314_204446_create_models_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('models', [
            'id' => 'pk',
            'name' => 'varchar(30) not null',
            'description' => 'string not null',
            'picture' => 'string not null',
            'comment' => 'string not null default ""',
            'created_by' => 'int not null',
            'modified_by' => 'int not null',
            'date_created' => 'datetime not null',
            'date_modified' => 'datetime not null',
            'is_deleted' => 'boolean not null default 0'
        ], 'engine=innodb default charset=utf8mb4');

        $this->addForeignKey('fk_models_created_by_user', 'models', 'created_by', 'users', 'id');
        $this->addForeignKey('fk_models_modified_by_user', 'models', 'modified_by', 'users', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('models');
    }

}
