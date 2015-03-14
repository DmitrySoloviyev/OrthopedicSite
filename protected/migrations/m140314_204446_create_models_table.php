<?php

class m140314_204446_create_models_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('models', [
            'id' => 'pk',
            'name' => 'string not null',
            'description' => 'text not null',
            'picture' => 'string not null default "ortho.jpg"',
            'comment' => 'text not null default ""',
            'author_id' => 'int not null',
            'modified_by' => 'int not null',
            'date_created' => 'datetime not null',
            'date_modified' => 'datetime not null',
            'is_deleted' => 'boolean not null default 0'
        ], 'engine=innodb default charset=utf8mb4');

        $this->addForeignKey('fk_models_author_id_user', 'models', 'author_id', 'users', 'id');
        $this->addForeignKey('fk_models_modified_by_user', 'models', 'modified_by', 'users', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('models');
    }

}
