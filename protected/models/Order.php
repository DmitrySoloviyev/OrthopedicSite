<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 *
 * @property integer $id
 * @property string $order_id
 * @property integer $model_id
 * @property integer $size_left_id
 * @property integer $size_right_id
 * @property integer $urk_left_id
 * @property integer $urk_right_id
 * @property integer $material_id
 * @property integer $height_left_id
 * @property integer $height_right_id
 * @property integer $top_volume_left_id
 * @property integer $top_volume_right_id
 * @property integer $ankle_volume_left_id
 * @property integer $ankle_volume_right_id
 * @property integer $kv_volume_left_id
 * @property integer $kv_volume_right_id
 * @property integer $customer_id
 * @property integer $employee_id
 * @property string $comment
 * @property string $date_created
 * @property string $date_modified
 *
 * The followings are the available model relations:
 * @property Models $model
 * @property Employee $employee
 * @property TopVolume $topVolumeLeft
 * @property TopVolume $topVolumeRight
 * @property Height $heightLeft
 * @property Height $heightRight
 * @property AnkleVolume $ankleVolumeLeft
 * @property AnkleVolume $ankleVolumeRight
 * @property KvVolume $kvVolumeLeft
 * @property KvVolume $kvVolumeRight
 * @property Urk $urkLeft
 * @property Urk $urkRight
 * @property Size $sizeLeft
 * @property Size $sizeRight
 * @property Material $material
 * @property Customer $customer
 */
class Order extends CActiveRecord
{
    public function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            ['order_id, model_id, size_left_id, size_right_id, urk_left_id, urk_right_id, material_id, height_left_id, height_right_id, top_volume_left_id, top_volume_right_id, ankle_volume_left_id, ankle_volume_right_id, kv_volume_left_id, kv_volume_right_id, customer_id, employee_id', 'required'],
            ['model_id, size_left_id, size_right_id, urk_left_id, urk_right_id, material_id, height_left_id, height_right_id, top_volume_left_id, top_volume_right_id, ankle_volume_left_id, ankle_volume_right_id, kv_volume_left_id, kv_volume_right_id, customer_id, employee_id', 'numerical', 'integerOnly' => true],
            ['order_id', 'unique', 'message' => 'Заказ с таким номером уже есть в базе!'],
            ['order_id', 'length', 'max' => 10],
            ['size', 'match', 'pattern' => '/(^(([2-4][0-9])|15|16|17|18|19)$)|(^(([2-4][0-9])|15|16|17|18|19) (([2-4][0-9])|15|16|17|18|19)$)/', 'on' => 'insert'],
            ['height', 'match', 'pattern' => '/(^(([1-3][0-9])|0|7|8|9|40)$)|(^(([1-3][0-9])|0|7|8|9|40) (([1-3][0-9])|0|7|8|9|40)$)/', 'on' => 'insert'],
            ['urk', 'match', 'pattern' => '/(^([1-3]\\d\\d)|400$)|(^([1-3]\\d\\d)|400 ([1-3]\\d\\d)|400$)/', 'on' => 'insert'],
            ['topVolume, ankleVolume', 'match', 'pattern' => '/(^(([1-4][0-9])|50)(\\.[05])?$)|(^(([1-4][0-9])|50)(\\.[05])? (([1-4][0-9])|50)(\\.[05])?$)/', 'on' => 'insert'],
            ['kvVolume', 'match', 'pattern' => '/(^(([2-6][0-9])|15|16|17|18|19|70)(\\.[05])?$)|(^(([2-6][0-9])|15|16|17|18|19|70)(\\.[05])? (([2-6][0-9])|15|16|17|18|19|70)(\\.[05])?$)/', 'on' => 'insert'],
            ['comment', 'length', 'max' => 255],

            ['model_id', 'exist', 'className' => 'Models', 'attributeName' => 'id', 'message' => 'Неизвестная модель'],
            ['material_id', 'exist', 'className' => 'Material', 'attributeName' => 'id', 'message' => 'Неизвестный материал'],
            ['employee_id', 'exist', 'className' => 'Employee', 'attributeName' => 'id', 'message' => 'Неизвестный модельер'],
            ['customer_id', 'exist', 'className' => 'Customer', 'attributeName' => 'id', 'message' => 'Неизвестный заказчик'],

            ['size_left_id', 'exist', 'className' => 'Size', 'attributeName' => 'id', 'message' => 'Неизвестный размер'],
            ['size_right_id', 'exist', 'className' => 'Size', 'attributeName' => 'id', 'message' => 'Неизвестный размер'],

            ['urk_left_id', 'exist', 'className' => 'Urk', 'attributeName' => 'id', 'message' => 'Неизвестный урк'],
            ['urk_right_id', 'exist', 'className' => 'Urk', 'attributeName' => 'id', 'message' => 'Неизвестный урк'],

            ['size_left_id', 'exist', 'className' => 'Size', 'attributeName' => 'id', 'message' => 'Неизвестный размер'],
            ['size_right_id', 'exist', 'className' => 'Size', 'attributeName' => 'id', 'message' => 'Неизвестный размер'],

            ['height_left_id', 'exist', 'className' => 'Height', 'attributeName' => 'id', 'message' => 'Неизвестная высота'],
            ['height_right_id', 'exist', 'className' => 'Height', 'attributeName' => 'id', 'message' => 'Неизвестная высота'],

            ['top_volume_left_id', 'exist', 'className' => 'TopVolume', 'attributeName' => 'id', 'message' => 'Неизвестный объем верха'],
            ['top_volume_right_id', 'exist', 'className' => 'TopVolume', 'attributeName' => 'id', 'message' => 'Неизвестный объем верха'],

            ['ankle_volume_left_id', 'exist', 'className' => 'AnkleVolume', 'attributeName' => 'id', 'message' => 'Неизвестный объем лодыжки'],
            ['ankle_volume_right_id', 'exist', 'className' => 'AnkleVolume', 'attributeName' => 'id', 'message' => 'Неизвестный объем лодыжки'],

            ['kv_volume_left_id', 'exist', 'className' => 'KvVolume', 'attributeName' => 'id', 'message' => 'Неизвестный объем КВ'],
            ['kv_volume_right_id', 'exist', 'className' => 'KvVolume', 'attributeName' => 'id', 'message' => 'Неизвестный объем КВ'],

            ['size_left_id, size_right_id', 'match', 'pattern' => '/^(([2-4][0-9])|15|16|17|18|19)$/'],
            ['height_left_id, height_right_id', 'match', 'pattern' => '/^(([1-3][0-9])|0|7|8|9|40)$/'],
            ['urk_left_id, urk_right_id', 'match', 'pattern' => '/^([1-3]\\d\\d)|400$/'],
            ['top_volume_left_id, top_volume_right_id, ankle_volume_left_id, ankle_volume_right_id', 'match', 'pattern' => '/^(([1-4][0-9])|50)(\\.[05])?$/'],
            ['kv_volume_left_id, kv_volume_right_id', 'match', 'pattern' => '/^(([2-6][0-9])|15|16|17|18|19|70)(\\.[05])?$/'],
            ['order_id, model_id, size_left_id, size_right_id, urk_left_id, urk_right_id, material_id, height_left_id, height_right_id, top_volume_left_id, top_volume_right_id, ankle_volume_left_id, ankle_volume_right_id, kv_volume_left_id, kv_volume_right_id, customer_id, employee_id, comment', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'model' => [self::BELONGS_TO, 'Models', 'model_id'],
            'topVolumeLeft' => [self::BELONGS_TO, 'TopVolume', 'top_volume_left_id'],
            'topVolumeRight' => [self::BELONGS_TO, 'TopVolume', 'top_volume_right_id'],
            'ankleVolumeLeft' => [self::BELONGS_TO, 'AnkleVolume', 'ankle_volume_left_id'],
            'ankleVolumeRight' => [self::BELONGS_TO, 'AnkleVolume', 'ankle_volume_right_id'],
            'kvVolumeLeft' => [self::BELONGS_TO, 'KvVolume', 'kv_volume_left_id'],
            'kvVolumeRight' => [self::BELONGS_TO, 'KvVolume', 'kv_volume_right_id'],
            'customer' => [self::BELONGS_TO, 'Customer', 'customer_id'],
            'employee' => [self::BELONGS_TO, 'Employee', 'employee_id'],
            'sizeLeft' => [self::BELONGS_TO, 'Size', 'size_left_id'],
            'sizeRight' => [self::BELONGS_TO, 'Size', 'size_right_id'],
            'urkLeft' => [self::BELONGS_TO, 'Urk', 'urk_left_id'],
            'urkRight' => [self::BELONGS_TO, 'Urk', 'urk_right_id'],
            'material' => [self::BELONGS_TO, 'Material', 'material_id'],
            'heightLeft' => [self::BELONGS_TO, 'Height', 'height_left_id'],
            'heightRight' => [self::BELONGS_TO, 'Height', 'height_right_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'order_id' => 'Номер заказа',
            'model_id' => 'Модель',
            'size' => 'Размер',
            'urk' => 'Урк',
            'material_id' => 'Материал',
            'height' => 'Высота',
            'topVolume' => 'Объем верха',
            'ankleVolume' => 'Объем лодыжки',
            'kvVolume' => 'Объем КВ',
            'employee_id' => 'Модельер',
            'comment' => 'Комментарий',
            'date_created' => 'Дата создания',
            'date_modified' => 'Дата изменения',
            'size_left_id' => 'Размер левый',
            'size_right_id' => 'Размер правый',
            'urk_left_id' => 'Урк левый',
            'urk_right_id' => 'Урк правый',
            'height_left_id' => 'Высота левый',
            'height_right_id' => 'Высота правый',
            'top_volume_left_id' => 'Объем верха левый',
            'top_volume_right_id' => 'Объем верха правый',
            'ankle_volume_left_id' => 'Объем лодыжки левый',
            'ankle_volume_right_id' => 'Объем лодыжки правый',
            'kv_volume_left_id' => 'Объем КВ левый',
            'kv_volume_right_id' => 'Объем КВ правый',
        ];
    }

    public function beforeValidate()
    {
        $this->size_left_id = $this->filter('Size', 'size', $this->size_left_id);
        $this->size_right_id = $this->filter('Size', 'size', $this->size_right_id);

        $this->urk_left_id = $this->filter('Urk', 'urk', $this->urk_left_id);
        $this->urk_right_id = $this->filter('Urk', 'urk', $this->urk_right_id);

        $this->height_left_id = $this->filter('Height', 'height', $this->height_left_id);
        $this->height_right_id = $this->filter('Height', 'height', $this->height_right_id);

        $this->top_volume_left_id = $this->filter('TopVolume', 'volume', $this->top_volume_left_id);
        $this->top_volume_right_id = $this->filter('TopVolume', 'volume', $this->top_volume_right_id);

        $this->ankle_volume_left_id = $this->filter('AnkleVolume', 'volume', $this->ankle_volume_left_id);
        $this->ankle_volume_right_id = $this->filter('AnkleVolume', 'volume', $this->ankle_volume_right_id);

        $this->kv_volume_left_id = $this->filter('KvVolume', 'volume', $this->kv_volume_left_id);
        $this->kv_volume_right_id = $this->filter('KvVolume', 'volume', $this->kv_volume_right_id);
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->date_created = new CDbExpression('NOW()');
        }
        $this->date_modified = new CDbExpression('NOW()');
    }

    private function filter($model, $field, $value)
    {
        $result = CActiveRecord::model($model)->findByAttributes([$field => $value]);
        if ($result) {
            return $result['id'];
        }

        return null;
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = [
            'sizeLeft', 'sizeRight',
            'urkLeft', 'urkRight',
            'heightLeft', 'sizeRight',
            'topVolumeLeft', 'topVolumeRight',
            'ankleVolumeLeft', 'ankleVolumeRight',
            'kvVolumeLeft', 'kvVolumeRight',
            'customer',
            'material', 'model',
        ];

        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('size_left_id', $this->size_left_id, true);
        $criteria->compare('size_right_id', $this->size_right_id, true);
        $criteria->compare('urk_left_id', $this->urk_left_id, true);
        $criteria->compare('urk_right_id', $this->urk_right_id, true);
        $criteria->compare('material_id', $this->material_id, true);
        $criteria->compare('height_left_id', $this->height_left_id, true);
        $criteria->compare('height_right_id', $this->height_right_id, true);
        $criteria->compare('top_volume_left_id', $this->top_volume_left_id, true);
        $criteria->compare('top_volume_right_id', $this->top_volume_right_id, true);
        $criteria->compare('ankle_volume_left_id', $this->ankle_volume_left_id, true);
        $criteria->compare('ankle_volume_right_id', $this->ankle_volume_right_id, true);
        $criteria->compare('kv_volume_left_id', $this->kv_volume_left_id, true);
        $criteria->compare('kv_volume_right_id', $this->kv_volume_right_id, true);
        $criteria->compare('customer_id', $this->customer_id, true);
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_modified', $this->date_modified, true);

        $sort = new CSort();
        $sort->attributes = [
            'defaultOrder' => 't.date_created DESC',
        ];

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
