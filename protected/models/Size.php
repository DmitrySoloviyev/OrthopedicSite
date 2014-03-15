<?php

/**
 * This is the model class for table "sizes".
 *
 * The followings are the available columns in table 'sizes':
 * @property integer $id
 * @property integer $size
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Order[] $orders1
 */
class Size extends CActiveRecord
{
    public $Size;

    public function tableName()
    {
        return 'sizes';
    }

    public function rules()
    {
        return [
            ['size', 'required'],
            ['size', 'numerical', 'integerOnly' => true],
            ['id, size', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'orders' => [self::HAS_MANY, 'Order', 'size_left_id'],
            'orders1' => [self::HAS_MANY, 'Order', 'size_right_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'size' => 'Размер',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
