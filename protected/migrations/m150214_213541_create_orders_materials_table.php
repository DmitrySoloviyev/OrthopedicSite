<?php

class m150214_213541_create_orders_materials_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('orders_materials', [
            'order_id' => 'int',
            'material_id' => 'int not null',
        ]);

        $this->addForeignKey('fk_orders_materials_order_id', 'orders_materials', 'order_id', 'orders', 'id');
        $this->addForeignKey('fk_orders_materials_material_id', 'orders_materials', 'material_id', 'materials', 'id');

        $this->addPrimaryKey('pk_order_id_material_id', 'orders_materials', 'order_id, material_id');
    }

    public function safeDown()
    {
        $this->dropTable('orders_materials');
    }

}
