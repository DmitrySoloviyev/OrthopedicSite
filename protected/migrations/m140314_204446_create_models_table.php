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
//            'author' => 'int not null',
            'date_created' => 'datetime not null',
            'date_modified' => 'datetime not null',
            'is_deleted' => 'boolean not null default 0'
        ], 'engine=innodb default charset=utf8');

//        $this->addForeignKey('fk_author', 'models', 'author', 'employees', 'id');
    }

	public function safeDown()
	{
        $this->dropTable('models');
	}

}
