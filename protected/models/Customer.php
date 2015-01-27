<?php

/**
 * This is the model class for table "customers".
 *
 * The followings are the available columns in table 'customers':
 *
 * @property integer $id
 * @property string $customer_surname
 * @property string $customer_name
 * @property string $customer_patronymic
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Customer extends CActiveRecord
{
    public function tableName()
    {
        return 'customers';
    }

    public function rules()
    {
        return [
            ['customer_surname, customer_name, customer_patronymic', 'required'],
            ['customer_surname, customer_name, customer_patronymic', 'length', 'max' => 30],
            ['customer_surname, customer_name, customer_patronymic', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'orders' => [self::HAS_MANY, 'Order', 'customer_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'customer_surname' => 'Фамилия заказчика',
            'customer_name' => 'Имя заказчика',
            'customer_patronymic' => 'Отчество заказчика',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function fullName()
    {
        return CHtml::encode($this->customer_surname . ' ' . $this->customer_name . ' ' . $this->customer_patronymic);
    }

}
