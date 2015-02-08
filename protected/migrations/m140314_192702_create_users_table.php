<?php

class m140314_192702_create_users_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => 'pk',
            'login' => 'string not null',
            'password' => 'string not null',
            'surname' => 'string not null',
            'name' => 'string not null',
            'patronymic' => 'string not null',
            'date_created' => 'datetime not null',
            'is_deleted' => 'boolean not null default 0',
        ], 'engine=innodb default charset=utf8mb4');

        $this->insert('users', [
            'login' => 'admin',
            'password' => md5('admin'),
            'surname' => 'admin',
            'name' => 'admin',
            'patronymic' => 'admin',
            'date_created' => new CDbExpression('NOW()'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('users');
    }

}
