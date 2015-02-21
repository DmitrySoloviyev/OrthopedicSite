<?php

class m140314_195125_create_customers_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('customers', [
            'id' => 'pk',
            'surname' => 'string not null',
            'name' => 'string not null',
            'patronymic' => 'string not null',
        ], 'engine=innodb default charset=utf8mb4');
    }

    public function safeDown()
    {
        $this->dropTable('customers');
    }

}
