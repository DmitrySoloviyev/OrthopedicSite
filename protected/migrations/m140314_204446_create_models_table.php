<?php

class m140314_204446_create_models_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('models', [
            'id' => 'pk',
            'name' => 'string not null',
            'picture' => 'string not null default "ortho.jpg"',
            'description' => 'text not null',
            'comment' => 'text not null',
            'author_id' => 'int not null',
            'modified_by' => 'int not null',
            'date_created' => 'datetime not null',
            'date_modified' => 'datetime not null',
            'is_deleted' => 'boolean not null default 0'
        ], 'engine=innodb default charset=utf8mb4');

        $this->addForeignKey('fk_models_author_id_user', 'models', 'author_id', 'users', 'id');
        $this->addForeignKey('fk_models_modified_by_user', 'models', 'modified_by', 'users', 'id');

        $this->createIndex('index_models_date_created', 'models', 'date_created');
        $this->createIndex('index_models_is_deleted', 'models', 'is_deleted');
    }

    public function safeDown()
    {
        $this->dropTable('models');
    }

}
