<?php

class m140314_192254_create_heights_table extends CDbMigration
{
	public function safeUp()
	{
        $this->createTable('heights', [
            'id' => 'pk',
            'height' => 'tinyint(2) unsigned not null'
        ], 'engine=innodb default charset=utf8');

        $this->insertMultiple('heights', [
            ['height' => 0],
            ['height' => 7],
            ['height' => 8],
            ['height' => 9],
            ['height' => 10],
            ['height' => 11],
            ['height' => 12],
            ['height' => 13],
            ['height' => 14],
            ['height' => 15],
            ['height' => 16],
            ['height' => 17],
            ['height' => 18],
            ['height' => 19],
            ['height' => 20],
            ['height' => 21],
            ['height' => 22],
            ['height' => 23],
            ['height' => 24],
            ['height' => 25],
            ['height' => 26],
            ['height' => 27],
            ['height' => 28],
            ['height' => 29],
            ['height' => 30],
            ['height' => 31],
            ['height' => 32],
            ['height' => 33],
            ['height' => 34],
            ['height' => 35],
            ['height' => 36],
            ['height' => 37],
            ['height' => 38],
            ['height' => 39],
            ['height' => 40],
        ]);
	}

	public function safeDown()
	{
        $this->dropTable('heights');
	}

}
