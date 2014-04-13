<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 01.04.14
 * Time: 23:48
 */
class UserCreateTest extends TestCase
{
    public $fixtures = [
        'employees' => 'Employee',
    ];

    public function testNewUser()
    {
        $data = [
            'Employee' => [
                'name' => 'Евгений',
                'surname' => 'Евгеденко',
                'patronymic' => 'Евгеньевич',
            ]
        ];

        $response = $this->sendPost('user/create', $data);
        print_r($response);
print_r(Yii::app()->db);
        print_r(Employee::model()->findAll());
    }
}
