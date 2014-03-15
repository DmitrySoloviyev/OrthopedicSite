<?php

/**
 * This is the model class for table "urks".
 *
 * The followings are the available columns in table 'urks':
 * @property integer $id
 * @property integer $urk
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Order[] $orders1
 */
class Urk extends CActiveRecord
{
    public function tableName()
    {
        return 'urks';
    }

    public function rules()
    {
        return [
            ['urk', 'required'],
            ['urk', 'numerical', 'integerOnly' => true],
            ['id, urk', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'orders' => [self::HAS_MANY, 'Order', 'urk_left_id'],
            'orders1' => [self::HAS_MANY, 'Order', 'urk_right_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'urk' => 'Урк',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
