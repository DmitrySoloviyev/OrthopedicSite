<?php

class m140314_205313_create_orders_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('orders', [
            'id' => 'pk',
            'order_id' => 'varchar(10) not null',
            'model_id' => 'int not null',
            'size_left_id' => 'int not null',
            'size_right_id' => 'int not null',
            'urk_left_id' => 'int not null',
            'urk_right_id' => 'int not null',
            'material_id' => 'int not null',
            'height_left_id' => 'int not null',
            'height_right_id' => 'int not null',
            'top_volume_left_id' => 'int not null',
            'top_volume_right_id' => 'int not null',
            'ankle_volume_left_id' => 'int not null',
            'ankle_volume_right_id' => 'int not null',
            'kv_volume_left_id' => 'int not null',
            'kv_volume_right_id' => 'int not null',
            'customer_id' => 'int not null',
            'employee_id' => 'int not null',
            'comment' => 'string not null default "-"',
            'date_created' => 'datetime not null',
            'date_modified' => 'datetime not null',
        ], 'engine=innodb default charset=utf8');

        $this->addForeignKey('fk_size_left', 'orders', 'size_left_id', 'sizes', 'id');
        $this->addForeignKey('fk_size_right', 'orders', 'size_right_id', 'sizes', 'id');

        $this->addForeignKey('fk_urk_left', 'orders', 'urk_left_id', 'urks', 'id');
        $this->addForeignKey('fk_urk_right', 'orders', 'urk_right_id', 'urks', 'id');

        $this->addForeignKey('fk_height_left', 'orders', 'height_left_id', 'heights', 'id');
        $this->addForeignKey('fk_height_right', 'orders', 'height_right_id', 'heights', 'id');

        $this->addForeignKey('fk_top_volume_left', 'orders', 'top_volume_left_id', 'top_volume', 'id');
        $this->addForeignKey('fk_top_volume_right', 'orders', 'top_volume_right_id', 'top_volume', 'id');

        $this->addForeignKey('fk_ankle_volume_left', 'orders', 'ankle_volume_left_id', 'ankle_volume', 'id');
        $this->addForeignKey('fk_ankle_volume_right', 'orders', 'ankle_volume_right_id', 'ankle_volume', 'id');

        $this->addForeignKey('fk_kv_volume_left', 'orders', 'kv_volume_left_id', 'kv_volume', 'id');
        $this->addForeignKey('fk_kv_volume_right', 'orders', 'kv_volume_right_id', 'kv_volume', 'id');

        $this->addForeignKey('fk_model', 'orders', 'model_id', 'models', 'id');
        $this->addForeignKey('fk_material', 'orders', 'material_id', 'materials', 'id');
        $this->addForeignKey('fk_customer', 'orders', 'customer_id', 'customers', 'id');
        $this->addForeignKey('fk_employee', 'orders', 'employee_id', 'employees', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('orders');
    }

}
