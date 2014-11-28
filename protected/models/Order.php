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
 * @property boolean $is_deleted
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
    public $sizes;
    public $urks;
    public $heights;
    public $top_volumes;
    public $ankle_volumes;
    public $kv_volumes;

    public function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            ['order_id, sizes, urks, heights, top_volumes, ankle_volumes, kv_volumes, model_id, size_left_id, size_right_id, urk_left_id, urk_right_id, material_id, height_left_id, height_right_id, top_volume_left_id, top_volume_right_id, ankle_volume_left_id, ankle_volume_right_id, kv_volume_left_id, kv_volume_right_id, customer_id, employee_id', 'required'],
            ['model_id, size_left_id, size_right_id, urk_left_id, urk_right_id, material_id, height_left_id, height_right_id, top_volume_left_id, top_volume_right_id, ankle_volume_left_id, ankle_volume_right_id, kv_volume_left_id, kv_volume_right_id, customer_id, employee_id', 'numerical', 'integerOnly' => true],
            ['order_id', 'unique', 'message' => 'Заказ с таким номером уже есть в базе!'],
            ['order_id', 'length', 'max' => 10],
            ['is_deleted', 'boolean'],
            ['sizes', 'match', 'pattern' => '/(^(([2-4][0-9])|15|16|17|18|19)$)|(^(([2-4][0-9])|15|16|17|18|19) (([2-4][0-9])|15|16|17|18|19)$)/'],
            ['heights', 'match', 'pattern' => '/(^(([1-3][0-9])|0|7|8|9|40)$)|(^(([1-3][0-9])|0|7|8|9|40) (([1-3][0-9])|0|7|8|9|40)$)/'],
            ['urks', 'match', 'pattern' => '/(^([1-3]\\d\\d)|400$)|(^([1-3]\\d\\d)|400 ([1-3]\\d\\d)|400$)/'],
            ['top_volumes, ankle_volumes', 'match', 'pattern' => '/(^(([1-4][0-9])|50)(\\.[05])?$)|(^(([1-4][0-9])|50)(\\.[05])? (([1-4][0-9])|50)(\\.[05])?$)/'],
            ['kv_volumes', 'match', 'pattern' => '/(^(([2-6][0-9])|15|16|17|18|19|70)(\\.[05])?$)|(^(([2-6][0-9])|15|16|17|18|19|70)(\\.[05])? (([2-6][0-9])|15|16|17|18|19|70)(\\.[05])?$)/', 'on' => 'insert'],
            ['comment', 'length', 'max' => 255],
            ['order_id, sizes, urks, heights, top_volumes, ankle_volumes, kv_volumes, model_id, size_left_id, size_right_id, urk_left_id, urk_right_id, material_id, height_left_id, height_right_id, top_volume_left_id, top_volume_right_id, ankle_volume_left_id, ankle_volume_right_id, kv_volume_left_id, kv_volume_right_id, customer_id, employee_id, comment, is_deleted', 'safe', 'on' => 'search'],
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
            'urk' => 'УРК',
            'material_id' => 'Материал',
            'height' => 'Высота',
            'topVolume' => 'Объем верха',
            'ankleVolume' => 'Объем лодыжки',
            'kvVolume' => 'Объем КВ',
            'employee_id' => 'Модельер',
            'customer_id' => 'Заказчик',
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

            'sizes' => 'Размер',
            'urks' => 'УРК',
            'heights' => 'Высота',
            'top_volumes' => 'Объем верха',
            'ankle_volumes' => 'Объем лодыжки',
            'kv_volumes' => 'Объем КВ',
        ];
    }

    public function beforeValidate()
    {
        $this->preFilter($this->sizes, 'size');
        $this->preFilter($this->urks, 'urk');
        $this->preFilter($this->heights, 'height');
        $this->preFilter($this->top_volumes, 'top_volume');
        $this->preFilter($this->ankle_volumes, 'ankle_volume');
        $this->preFilter($this->kv_volumes, 'kv_volume');


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

        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->date_created = new CDbExpression('NOW()');
        }
        $this->date_modified = new CDbExpression('NOW()');

        return parent::beforeSave();
    }

    /**
     * 1 input, 2 параметра
     * разбивка введенных значений
     *
     * @param $value
     * @param $attribute
     */
    private function preFilter($value, $attribute)
    {
        if (strlen($value) > $this->getMaxInputChars($attribute)) {
            // если длина введеной строки больше 2х цифр, значит для каждой ноги введено свое значение
            $array_value = explode(' ', $value);
            $this->{$attribute . '_left_id'} = $array_value[0];
            $this->{$attribute . '_right_id'} = $array_value[1];
        } else {
            $this->{$attribute . '_left_id'} = $this->{$attribute . '_right_id'} = $value;
        }
    }

    private function getMaxInputChars($attribute)
    {
        switch ($attribute) {
            case 'size':
                return 2;
                break;
            case 'urk':
                return 3;
                break;
            case 'height':
                return 2;
                break;
            case 'top_volume':
                return 4;
                break;
            case 'ankle_volume':
                return 4;
                break;
            case 'kv_volume':
                return 4;
                break;
        }
    }

    /**
     * Нахождение id связанных данных
     *
     * @param $model
     * @param $field
     * @param $value
     * @return null
     */
    private function filter($model, $field, $value)
    {
        $result = CActiveRecord::model($model)->findByAttributes([$field => $value]);
        if ($result) {
            return $result['id'];
        }

        return null;
    }

    public function delete()
    {
        $this->is_deleted = 1;

        return $this->save(false);
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = [
            'sizeLeft', 'sizeRight',
            'urkLeft', 'urkRight',
            'heightLeft', 'heightRight',
            'topVolumeLeft', 'topVolumeRight',
            'ankleVolumeLeft', 'ankleVolumeRight',
            'kvVolumeLeft', 'kvVolumeRight',
            'employee',
            'material', 'model',
        ];

        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('model.name', $this->model_id, true);

        $criteria->compare('sizeLeft.size', $this->sizes, true);
        $criteria->compare('sizeRight.size', $this->sizes, true, 'OR');

        $criteria->compare('urkLeft.urk', $this->urks, true);
        $criteria->compare('urkRight.urk', $this->urks, true, 'OR');

        $criteria->compare('material.material_name', $this->material_id, true);

        $criteria->compare('heightLeft.height', $this->heights, true);
        $criteria->compare('heightRight.height', $this->heights, true, 'OR');

        $criteria->compare('topVolumeLeft.volume', $this->top_volumes, true);
        $criteria->compare('topVolumeRight.volume', $this->top_volumes, true, 'OR');

        $criteria->compare('ankleVolumeLeft.value', $this->ankle_volumes, true);
        $criteria->compare('ankleVolumeRight.value', $this->ankle_volumes, true, 'OR');

        $criteria->compare('kvVolumeLeft.value', $this->kv_volumes, true);
        $criteria->compare('kvVolumeRight.value', $this->kv_volumes, true, 'OR');

        $criteria->compare('customer.surname', $this->customer_id, true);
        $criteria->compare('customer.name', $this->customer_id, true, 'OR');
        $criteria->compare('customer.patronymic', $this->customer_id, true, 'OR');

        $criteria->compare('employee.surname', $this->employee_id, true);
        $criteria->compare('employee.name', $this->employee_id, true, 'OR');
        $criteria->compare('employee.patronymic', $this->employee_id, true, 'OR');

        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_modified', $this->date_modified, true);
        $criteria->compare('t.is_deleted', 0);

        $sort = new CSort();
        $sort->attributes = [
            'defaultOrder' => 't.date_created DESC',
            'sizes' => [
                'asc' => 'sizeLeft.size',
                'desc' => 'sizeLeft.size desc',
            ],
            'urks' => [
                'asc' => 'urkLeft.urk',
                'desc' => 'urkRight.urk desc',
            ],
            'material_id' => [
                'asc' => 'material.material_name',
                'desc' => 'material.material_name desc',
            ],
            'heights' => [
                'asc' => 'heightLeft.height',
                'desc' => 'heightLeft.height desc',
            ],
            'top_volumes' => [
                'asc' => 'topVolumeLeft.volume',
                'desc' => 'topVolumeLeft.volume desc',
            ],
            'ankle_volumes' => [
                'asc' => 'ankleVolumeLeft.value',
                'desc' => 'ankleVolumeLeft.value desc',
            ],
            'kv_volumes' => [
                'asc' => 'kvVolumeLeft.value',
                'desc' => 'kvVolumeLeft.value desc',
            ],
            '*', // Make all other columns sortable, too

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

    /**
     * Общая оценка производительности по дням недели
     *
     * @return array
     */
    public static function performanceByDay()
    {
        return Yii::app()->db->createCommand()
            ->select([
                'COUNT(*) AS orders_count',
                'DAYOFMONTH(date_created) AS day_of_month',
                'MONTHNAME(date_created) AS month_name',
                'DATE(date_created) AS date_created',
            ])
            ->from('orders')
            ->where('is_deleted = 0 AND date_created BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()')
            ->group('month_name, day_of_month')
            ->order('date_created')
            ->queryAll();
    }

    /**
     * Оценка производительности модельеров по дням недели
     */
    public static function performanceByEmployee()
    { /*
        "SELECT
          COUNT(DAY(o.date_created)) AS COUNT,
          DAYOFMONTH(o.date_created) AS DAY,
          MONTHNAME(o.date_created) AS MONTH,
          DATE(o.date_created) AS DAYDATE,
          o.employee_id,
          CONCAT(e.surname, " ", LEFT(e.name, 1), ".", LEFT(e.patronymic, 1), ".") as employee
		FROM orders o
		JOIN employees e ON e.id = o.employee_id
		WHERE o.is_deleted = 0 AND o.date_created BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()
		GROUP BY DAY, o.employee_id, MONTH ORDER BY o.employee_id, DAYDATE";
*/
        return Yii::app()->db->createCommand()
            ->select([
                'COUNT(*) AS orders_count',
                'DAYOFMONTH(o.date_created) AS day_of_month',
                'MONTHNAME(o.date_created) AS month_name',
                'DATE(o.date_created) AS date_created',
                'o.employee_id',
                'CONCAT(e.surname, " ", LEFT(e.name, 1), ".", LEFT(e.patronymic, 1), ".") as employee',
            ])
            ->from('orders o')
            ->join('employees e', 'e.id = o.employee_id')
            ->where('o.is_deleted = 0 AND o.date_created BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()')
            ->group('day_of_month, o.employee_id, month_name')
            ->order('o.employee_id, o.date_created')
            ->queryAll();
    }

    /**
     * Объем реализованных заказов по модельерам за последние 3 месяца
     */
    public static function performanceByEmployeeSummaryPie()
    {
        return Yii::app()->db->createCommand()
            ->select([
                'COUNT(*) AS orders_count',
                'CONCAT(e.surname, " ", LEFT(e.name, 1), ".", LEFT(e.patronymic, 1), ".") as employee',
            ])
            ->from('orders o')
            ->join('employees e', 'e.id = o.employee_id')
            ->where('o.is_deleted = 0 AND o.date_created BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()')
            ->group('o.employee_id')
            ->queryAll();
    }

    public static function hasOrders()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'COUNT(*)';
        $criteria->addBetweenCondition('t.date_created', new CDbExpression('DATE_SUB(NOW(), INTERVAL 2 MONTH)'), new CDbExpression('NOW()'));
        $criteria->compare('t.is_deleted', 1);

        return self::model()->find($criteria)->count('t.is_deleted = 0');
    }

}
