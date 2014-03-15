<?php

class m140312_185953_create_sizes_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('sizes', [
            'id' => 'pk',
            'size' => 'tinyint(2) unsigned not null'
        ], 'engine=innodb default charset=utf8');

        $this->insertMultiple('sizes', [
            ['size' => 15],
            ['size' => 16],
            ['size' => 17],
            ['size' => 18],
            ['size' => 19],
            ['size' => 20],
            ['size' => 21],
            ['size' => 22],
            ['size' => 23],
            ['size' => 24],
            ['size' => 25],
            ['size' => 26],
            ['size' => 27],
            ['size' => 28],
            ['size' => 29],
            ['size' => 30],
            ['size' => 31],
            ['size' => 32],
            ['size' => 33],
            ['size' => 34],
            ['size' => 35],
            ['size' => 36],
            ['size' => 37],
            ['size' => 38],
            ['size' => 39],
            ['size' => 40],
            ['size' => 41],
            ['size' => 42],
            ['size' => 43],
            ['size' => 44],
            ['size' => 45],
            ['size' => 46],
            ['size' => 47],
            ['size' => 48],
            ['size' => 49],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('sizes');
    }

}
