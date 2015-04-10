<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 10.08.14
 * Time: 11:10
 */
class FakeDataCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        /** @var CDbCommand $command */
        $command = Yii::app()->db->createCommand();


        /** Модельеры */
        echo "Модельеры... ";
        for ($i = 0; $i <= 100; $i++) {
            $command->insert('users', [
                'login' => 'login' . $i,
                'password' => md5('user' . $i),
                'surname' => 'Фамилия ' . $i,
                'name' => 'Имя ' . $i,
                'patronymic' => 'Отчество ' . $i,
                'date_created' => new CDbExpression('timestamp(NOW()) - INTERVAL FLOOR( RAND( ) * 566) DAY'),
                'is_deleted' => rand(0, 1),
            ]);
        }
        echo "OK\r\n";

        gc_collect_cycles();
        sleep(2);

        echo "Материалы... ";
        for ($i = 0; $i <= 1000; $i++) {
            $command->insert('materials', [
                'title' => 'Материал ' . $i,
                'author_id' => rand(1, 100),
                'modified_by' => rand(1, 100),
                'date_created' => new CDbExpression('timestamp(NOW()) - INTERVAL FLOOR( RAND( ) * 566) DAY'),
                'date_modified' => new CDbExpression('timestamp(NOW()) - INTERVAL FLOOR( RAND( ) * 566) DAY'),
                'is_deleted' => rand(0, 1),
            ]);
        }
        echo "OK\r\n";

        gc_collect_cycles();
        sleep(2);

        echo "Модели... ";
        for ($i = 0; $i <= 200000; $i++) {
            $command->insert('models', [
                'name' => 'Модель ' . $i,
                'description' => $this->randString(rand(400, 600)),
                'comment' => $this->randString(rand(400, 600)),
                'author_id' => rand(1, 100),
                'modified_by' => rand(1, 100),
                'date_created' => new CDbExpression('timestamp(NOW()) - INTERVAL FLOOR( RAND( ) * 566) DAY'),
                'date_modified' => new CDbExpression('timestamp(NOW()) - INTERVAL FLOOR( RAND( ) * 566) DAY'),
                'is_deleted' => rand(0, 1),
            ]);
        }
        echo "OK\r\n";

        gc_collect_cycles();
        sleep(2);

        echo "Заказчики... ";
        for ($i = 0; $i <= 500000; $i++) {
            $command->insert('customers', [
                'surname' => 'Фамилия ' . $i,
                'name' => 'Имя ' . $i,
                'patronymic' => 'Отчество ' . $i,
            ]);
        }
        echo "OK\r\n";

        gc_collect_cycles();
        sleep(2);

        echo "Заказы... ";
        for ($i = 0; $i <= 500000; $i++) {
            $command->insert('orders', [
                'order_name' => '№ ' . $i,
                'model_id' => rand(1, 200000),
                'size_left' => rand(15, 49),
                'size_right' => rand(15, 49),
                'urk_left' => rand(100, 400),
                'urk_right' => rand(100, 400),
                'height_left' => rand(7, 40),
                'height_right' => rand(7, 40),
                'top_volume_left' => rand(10, 50),
                'top_volume_right' => rand(10, 50),
                'ankle_volume_left' => rand(10, 50),
                'ankle_volume_right' => rand(10, 50),
                'kv_volume_left' => rand(15, 70),
                'kv_volume_right' => rand(15, 70),
                'comment' => $this->randString(rand(400, 600)),
                'customer_id' => rand(1, 500000),
                'author_id' => rand(1, 100),
                'modified_by' => rand(1, 100),
                'date_created' => new CDbExpression('timestamp(NOW()) - INTERVAL FLOOR( RAND( ) * 865) DAY'),
                'date_modified' => new CDbExpression('timestamp(NOW()) - INTERVAL FLOOR( RAND( ) * 865) DAY'),
                'is_deleted' => rand(0, 1),
            ]);
            $command->insert('orders_materials', [
                'order_id' => $i + 1,
                'material_id' => rand(1, 1000),
            ]);
            if ($i % 100000 == 0)
                echo ' ' . $i . '.. ';
        }
        echo "OK\r\n";

        gc_collect_cycles();
    }

    /**
     * Генерация случайной строки
     * @param $length
     * @return string
     */
    private function randString($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
            if ($i % 6 == 0)
                $str .= ' ';
        }

        return $str;
    }

}
