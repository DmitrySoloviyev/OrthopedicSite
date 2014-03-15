<?php

class m140314_195125_create_customers_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('customers', [
            'id' => 'pk',
            'surname' => 'varchar(30) not null',
            'name' => 'varchar(30) not null',
            'patronymic' => 'varchar(30) not null',
        ], 'engine=innodb default charset=utf8');
    }

    public function safeDown()
    {
        $this->dropTable('customers');
    }

}
