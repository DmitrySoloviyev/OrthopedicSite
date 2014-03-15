<?php

/**
 * This is the model class for table "ankle_volume".
 *
 * The followings are the available columns in table 'ankle_volume':
 * @property string integer $id
 * @property double $volume
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Order[] $orders1
 */
class AnkleVolume extends CActiveRecord
{
    public function tableName()
    {
        return 'ankle_volume';
    }

    public function rules()
    {
        return [
            ['volume', 'required'],
            ['volume', 'numerical'],
            ['id, volume', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return array(
            'orders' => array(self::HAS_MANY, 'Order', 'ankle_volume_left_id'),
            'orders1' => array(self::HAS_MANY, 'Order', 'ankle_volume_right_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'volume' => 'Объем лодыжки',
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
