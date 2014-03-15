<?php

/**
 * This is the model class for table "heights".
 *
 * The followings are the available columns in table 'heights':
 * @property integer $id
 * @property integer $height
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Order[] $orders1
 */
class Height extends CActiveRecord
{
    public function tableName()
    {
        return 'heights';
    }

    public function rules()
    {
        return [
            ['height', 'required'],
            ['height', 'numerical', 'integerOnly' => true],
            ['id, height', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'orders' => [self::HAS_MANY, 'Order', 'height_left_id'],
            'orders1' => [self::HAS_MANY, 'Order', 'height_right_id'],
        ];
    }

    public function attributeLabels()
    {
        return array(
            'height' => 'Высота',
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
