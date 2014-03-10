<?php

class m140310_213733_create_db extends CDbMigration
{
    public function safeUp()
    {
        $this->execute('CREATE DATABASE IF NOT EXISTS ortho_db DEFAULT CHARACTER SET utf8');
    }

    public function safeDown()
    {
        $this->execute('DROP DATABASE IF EXISTS ortho_db');
    }

}
