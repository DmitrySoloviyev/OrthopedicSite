<?php

/**
 * This is the model class for table "top_volume".
 *
 * The followings are the available columns in table 'top_volume':
 * @property integer $id
 * @property double $volume
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Order[] $orders1
 */
class TopVolume extends CActiveRecord
{
    public function tableName()
    {
        return 'top_volume';
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
            'orders' => [self::HAS_MANY, 'Order', 'top_volume_left_id'],
            'orders1' => [self::HAS_MANY, 'Order', 'top_volume_right_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'TopVolumeValue' => 'Объем верха',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
