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

//        echo Yii::app()->getBaseUrl(true);
//        echo Yii::app()->createAbsoluteUrl('user/create');
        $response = $this->sendPost('/user/create', $data);
        print_r($response);

//        print_r(Employee::model()->findAll());
//        $this->assertTrue(true);
        // phpunit --coverage-html report unit/UserCreateTest.php
    }
}
