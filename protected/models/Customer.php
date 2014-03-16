<?php

/**
 * This is the model class for table "customers".
 *
 * The followings are the available columns in table 'customers':
 * @property integer $id
 * @property string $surname
 * @property string $name
 * @property string $patronymic
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
            array('surname, name, patronymic', 'required'),
            array('surname, name, patronymic', 'length', 'max' => 30),
            array('surname, name, patronymic', 'safe', 'on' => 'search'),
        ];
    }

    public function relations()
    {
        return [
            'orders' => array(self::HAS_MANY, 'Order', 'customer_id'),
        ];
    }

    public function attributeLabels()
    {
        return [
            'surname' => 'Фамилия заказчика',
            'name' => 'Имя заказчика',
            'patronymic' => 'Отчество заказчика',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function fullName()
    {
        return CHtml::encode($this->surname . ' ' . $this->name . ' ' . $this->patronymic);
    }

}
