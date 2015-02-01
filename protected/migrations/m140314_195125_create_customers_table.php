<?php

class m140314_195125_create_customers_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('customers', [
            'id' => 'pk',
            'customer_surname' => 'varchar(30) not null',
            'customer_name' => 'varchar(30) not null',
            'customer_patronymic' => 'varchar(30) not null',
        ], 'engine=innodb default charset=utf8mb4');
    }

    public function safeDown()
    {
        $this->dropTable('customers');
    }

}
