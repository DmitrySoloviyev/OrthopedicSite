<?php

/**
 * This is the model class for table "kv_volume".
 *
 * The followings are the available columns in table 'kv_volume':
 * @property integer $id
 * @property double $volume
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Order[] $orders1
 */
class KvVolume extends CActiveRecord
{
    public function tableName()
    {
        return 'kv_volume';
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
        return [
            'orders' => [self::HAS_MANY, 'Order', 'kv_volume_left_id'],
            'orders1' => [self::HAS_MANY, 'Order', 'kv_volume_right_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'volume' => 'Объем КВ',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
