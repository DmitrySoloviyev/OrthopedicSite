<?php

/**
 * This is the model class for table "orders_materials".
 *
 * The followings are the available columns in table 'orders_materials':
 * @property integer $order_id
 * @property integer $material_id
 *
 * The followings are the available model relations:
 * @property Material $material
 * @property Order $order
 */
class OrdersMaterials extends CActiveRecord
{
    public function tableName()
    {
        return 'orders_materials';
    }

    public function rules()
    {
        return [
            ['order_id, material_id', 'required'],
            ['order_id, material_id', 'numerical', 'integerOnly' => true],
            ['order_id, material_id', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'material' => [self::BELONGS_TO, 'Material', 'material_id'],
            'order' => [self::BELONGS_TO, 'Order', 'order_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'order_id' => 'Заказ',
            'material_id' => 'Материал',
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('material_id', $this->material_id);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
