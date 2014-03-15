<?php

class m140314_203338_create_ankle_volume_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('ankle_volume', [
            'id' => 'pk',
            'volume' => 'float(3,1) unsigned not null',
        ], 'engine=innodb default charset=utf8');

        $this->insertMultiple('ankle_volume', [
            ['volume' => 10.0],
            ['volume' => 10.5],
            ['volume' => 11.0],
            ['volume' => 11.5],
            ['volume' => 12.0],
            ['volume' => 12.5],
            ['volume' => 13.0],
            ['volume' => 13.5],
            ['volume' => 14.0],
            ['volume' => 14.5],
            ['volume' => 15.0],
            ['volume' => 15.5],
            ['volume' => 16.0],
            ['volume' => 16.5],
            ['volume' => 17.0],
            ['volume' => 17.5],
            ['volume' => 18.0],
            ['volume' => 18.5],
            ['volume' => 19.0],
            ['volume' => 19.5],
            ['volume' => 20.0],
            ['volume' => 20.5],
            ['volume' => 21.0],
            ['volume' => 21.5],
            ['volume' => 22.0],
            ['volume' => 22.5],
            ['volume' => 23.0],
            ['volume' => 23.5],
            ['volume' => 24.0],
            ['volume' => 24.5],
            ['volume' => 25.0],
            ['volume' => 25.5],
            ['volume' => 26.0],
            ['volume' => 26.5],
            ['volume' => 27.0],
            ['volume' => 27.5],
            ['volume' => 28.0],
            ['volume' => 28.5],
            ['volume' => 29.0],
            ['volume' => 29.5],
            ['volume' => 30.0],
            ['volume' => 30.5],
            ['volume' => 31.0],
            ['volume' => 31.5],
            ['volume' => 32.0],
            ['volume' => 32.5],
            ['volume' => 33.0],
            ['volume' => 33.5],
            ['volume' => 34.0],
            ['volume' => 34.5],
            ['volume' => 35.0],
            ['volume' => 35.5],
            ['volume' => 36.0],
            ['volume' => 36.5],
            ['volume' => 37.0],
            ['volume' => 37.5],
            ['volume' => 38.0],
            ['volume' => 38.5],
            ['volume' => 39.0],
            ['volume' => 39.5],
            ['volume' => 40.0],
            ['volume' => 40.5],
            ['volume' => 41.0],
            ['volume' => 41.5],
            ['volume' => 42.0],
            ['volume' => 42.5],
            ['volume' => 43.0],
            ['volume' => 43.5],
            ['volume' => 44.0],
            ['volume' => 44.5],
            ['volume' => 45.0],
            ['volume' => 45.5],
            ['volume' => 46.0],
            ['volume' => 46.5],
            ['volume' => 47.0],
            ['volume' => 47.5],
            ['volume' => 48.0],
            ['volume' => 48.5],
            ['volume' => 49.0],
            ['volume' => 49.5],
            ['volume' => 50.0],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('ankle_volume');
    }

}
