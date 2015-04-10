<?php

class m140314_205313_create_orders_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('orders', [
            'id' => 'pk',
            'order_name' => 'varchar(10) not null',
            'model_id' => 'int not null',
            'size_left' => 'tinyint(2) unsigned not null',  // 15 - 49
            'size_right' => 'tinyint(2) unsigned not null', // 15 - 49
            'urk_left' => 'smallint(3) unsigned not null',  // 100 - 400
            'urk_right' => 'smallint(3) unsigned not null', // 100 - 400
            'height_left' => 'tinyint(2) unsigned not null',   // 0, 7 - 40
            'height_right' => 'tinyint(2) unsigned not null',  // 0, 7 - 40
            'top_volume_left' => 'float unsigned not null',    // 10.0 - 50.0 float(3,1) unsigned not null
            'top_volume_right' => 'float unsigned not null',   // 10.0 - 50.0 float(3,1) unsigned not null
            'ankle_volume_left' => 'float unsigned not null',  // 10.0 - 50.0 float(3,1) unsigned not null
            'ankle_volume_right' => 'float unsigned not null', // 10.0 - 50.0 float(3,1) unsigned not null
            'kv_volume_left' => 'float unsigned not null',     // 15.0 - 70.0 float(3,1) unsigned not null
            'kv_volume_right' => 'float unsigned not null',    // 15.0 - 70.0 float(3,1) unsigned not null
            'comment' => 'text not null',
            'customer_id' => 'int not null',
            'author_id' => 'int not null',
            'modified_by' => 'int not null',
            'date_created' => 'datetime not null',
            'date_modified' => 'datetime not null',
            'is_deleted' => 'boolean not null default 0'
        ], 'engine=innodb default charset=utf8mb4');

        $this->addForeignKey('fk_model', 'orders', 'model_id', 'models', 'id');
        $this->addForeignKey('fk_customer', 'orders', 'customer_id', 'customers', 'id');
        $this->addForeignKey('fk_orders_user', 'orders', 'author_id', 'users', 'id');
        $this->addForeignKey('fk_orders_modified_by_user', 'orders', 'modified_by', 'users', 'id');

        $this->createIndex('unique_order_name', 'orders', 'order_name', true);
        $this->createIndex('index_orders_date_created', 'orders', 'date_created');
        $this->createIndex('index_orders_is_deleted', 'orders', 'is_deleted');
    }

    public function safeDown()
    {
        $this->dropTable('orders');
    }

}
