<?php

class m140314_192702_create_employees_table extends CDbMigration
{
	public function safeUp()
	{
        $this->createTable('employees', [
            'id' => 'pk',
            'surname' => 'varchar(30) not null',
            'name' => 'varchar(30) not null',
            'patronymic' => 'varchar(30) not null',
            'date_created' => 'datetime not null ',
            'is_deleted' => 'boolean not null default 0',
        ], 'engine=innodb default charset=utf8mb4');
	}

	public function safeDown()
	{
        $this->dropTable('employees');
	}

}
