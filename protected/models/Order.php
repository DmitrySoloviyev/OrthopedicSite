<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 *
 * @property integer $id
 * @property string $order_name
 * @property integer $model_id
 * @property integer $size_left
 * @property integer $size_right
 * @property integer $urk_left
 * @property integer $urk_right
 * @property integer $material_id
 * @property integer $height_left
 * @property integer $height_right
 * @property integer $top_volume_left
 * @property integer $top_volume_right
 * @property integer $ankle_volume_left
 * @property integer $ankle_volume_right
 * @property integer $kv_volume_left
 * @property integer $kv_volume_right
 * @property integer $customer_id
 * @property integer $user_id
 * @property string $comment
 * @property string $date_created
 * @property string $date_modified
 * @property string $modified_by
 * @property boolean $is_deleted
 *
 * The followings are the available model relations:
 * @property Models $model
 * @property User $user
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
            ['order_name, model_id, size_left, size_right, urk_left, urk_right, material_id, height_left, height_right, top_volume_left, top_volume_right, ankle_volume_left, ankle_volume_right, kv_volume_left, kv_volume_right, customer_id, user_id', 'required'],
            ['model_id,  material_id,  customer_id, user_id', 'numerical', 'integerOnly' => true],
            ['size_left, size_right', 'numerical', 'integerOnly' => true, 'min' => 15, 'max' => 49],
            ['urk_left, urk_right', 'numerical', 'integerOnly' => true, 'min' => 100, 'max' => 400],
            ['height_left, height_right', 'numerical', 'integerOnly' => true, 'max' => 40],
            ['top_volume_left, top_volume_right, ankle_volume_left, ankle_volume_right, kv_volume_left, kv_volume_right', 'numerical', 'integerOnly' => false, 'numberPattern' => '/^\\d\\d(?:\\.[05])?$/'],
            ['order_name', 'unique', 'message' => 'Заказ с таким номером уже существует!'],
            ['order_name', 'length', 'max' => 10],
            ['is_deleted', 'boolean'],
            ['comment', 'length', 'max' => 255],
            ['date_created, date_modified, order_name, sizes, urks, heights, top_volumes, ankle_volumes, kv_volumes, model_id, size_left, size_right, urk_left, urk_right, material_id, height_left, height_right, top_volume_left, top_volume_right, ankle_volume_left, ankle_volume_right, kv_volume_left, kv_volume_right, customer_id, user_id, comment, is_deleted, modified_by', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'model' => [self::BELONGS_TO, 'Models', 'model_id'],
            'customer' => [self::BELONGS_TO, 'Customer', 'customer_id'],
            'user' => [self::BELONGS_TO, 'User', 'user_id'],
            'material' => [self::BELONGS_TO, 'Material', 'material_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'order_name' => 'Номер заказа',
            'model_id' => 'Модель',
            'material_id' => 'Материал',
            'user_id' => 'Автор',
            'customer_id' => 'Заказчик',
            'comment' => 'Комментарий',
            'date_created' => 'Дата создания',
            'date_modified' => 'Дата изменения',
            'modified_by' => 'Изменил',
            'size_left' => 'Размер левый',
            'size_right' => 'Размер правый',
            'urk_left' => 'Урк левый',
            'urk_right' => 'Урк правый',
            'height_left' => 'Высота левый',
            'height_right' => 'Высота правый',
            'top_volume_left' => 'Объем верха левый',
            'top_volume_right' => 'Объем верха правый',
            'ankle_volume_left' => 'Объем лодыжки левый',
            'ankle_volume_right' => 'Объем лодыжки правый',
            'kv_volume_left' => 'Объем КВ левый',
            'kv_volume_right' => 'Объем КВ правый',

            'sizes' => 'Размер',
            'urks' => 'УРК',
            'heights' => 'Высота',
            'top_volumes' => 'Объем верха',
            'ankle_volumes' => 'Объем лодыжки',
            'kv_volumes' => 'Объем КВ',
        ];
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->date_created = new CDbExpression('NOW()');
        }
        $this->date_modified = new CDbExpression('NOW()');

        return parent::beforeSave();
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
            'user', 'customer',
            'material', 'model',
        ];

        $criteria->compare('order_name', $this->order_name, true);
        $criteria->compare('model.name', $this->model_id, true);

        $criteria->compare('size_left', $this->sizes);
        $criteria->compare('size_right', $this->sizes);

        $criteria->compare('urk_left', $this->urks);
        $criteria->compare('urk_right', $this->urks);

        $criteria->compare('material.title', $this->material_id);

        $criteria->compare('height_left', $this->heights);
        $criteria->compare('height_right', $this->heights);

        $criteria->compare('top_volume_left', $this->top_volumes);
        $criteria->compare('top_volume_right', $this->top_volumes);

        $criteria->compare('ankle_volume_left', $this->ankle_volumes);
        $criteria->compare('ankle_volume_right', $this->ankle_volumes);

        $criteria->compare('kv_volume_left', $this->kv_volumes);
        $criteria->compare('kv_volume_right', $this->kv_volumes);

        $criteria->compare('customer_surname', $this->customer_id);
        $criteria->compare('customer_name', $this->customer_id);
        $criteria->compare('customer_patronymic', $this->customer_id);

        $criteria->compare('user.surname', $this->user_id);
        $criteria->compare('user.name', $this->user_id);
        $criteria->compare('user.patronymic', $this->user_id);

        $criteria->compare('t.comment', $this->comment, true);
        $criteria->compare('date_created', $this->date_created);
        $criteria->compare('date_modified', $this->date_modified);
        $criteria->compare('t.is_deleted', 0);
        $criteria->order = 't.date_created DESC';

        $sort = new CSort();
        $sort->attributes = [
            'defaultOrder' => 't.date_created DESC',
            'sizes' => [
                'asc' => 'size_left',
                'desc' => 'size_left desc',
            ],
            'urks' => [
                'asc' => 'urk_left',
                'desc' => 'urk_right desc',
            ],
            'material_id' => [
                'asc' => 'material.title',
                'desc' => 'material.title desc',
            ],
            'heights' => [
                'asc' => 'height_left',
                'desc' => 'height_left desc',
            ],
            'top_volumes' => [
                'asc' => 'top_volume_left',
                'desc' => 'top_volume_left desc',
            ],
            'ankle_volumes' => [
                'asc' => 'ankle_volume_left',
                'desc' => 'ankle_volume_left desc',
            ],
            'kv_volumes' => [
                'asc' => 'kv_volume_left',
                'desc' => 'kv_volume_left desc',
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
    public static function performanceByUser()
    {
        return Yii::app()->db->createCommand()
            ->select([
                'COUNT(*) AS orders_count',
                'DAYOFMONTH(o.date_created) AS day_of_month',
                'MONTHNAME(o.date_created) AS month_name',
                'DATE(o.date_created) AS date_created',
                'o.user_id',
                'CONCAT(u.surname, " ", LEFT(u.name, 1), ".", LEFT(u.patronymic, 1), ".") as user',
            ])
            ->from('orders o')
            ->join('users u', 'u.id = o.user_id')
            ->where('o.is_deleted = 0 AND o.date_created BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()')
            ->group('day_of_month, o.user_id, month_name')
            ->order('o.user_id, o.date_created')
            ->queryAll();
    }

    /**
     * Объем реализованных заказов по модельерам за последние 3 месяца
     */
    public static function performanceByUserSummaryPie()
    {
        return Yii::app()->db->createCommand()
            ->select([
                'COUNT(*) AS orders_count',
                'CONCAT(u.surname, " ", LEFT(u.name, 1), ".", LEFT(u.patronymic, 1), ".") as user',
            ])
            ->from('orders o')
            ->join('users u', 'u.id = o.user_id')
            ->where('o.is_deleted = 0 AND o.date_created BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()')
            ->group('o.user_id')
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

    public function showSearchResults()
    {
        echo 'Найденные заказы:';
    }

    public function viewDir()
    {
        return 'order';
    }

    public function siteSearch($query)
    {
        $criteria = new CDbCriteria;
        $criteria->with = [
            'user', 'customer',
            'material', 'model',
        ];
        $criteria->compare('t.order_name', $query, true, 'OR');
        $criteria->compare('t.model_id', $query, true, 'OR');
        $criteria->compare('t.size_left', $query, true, 'OR');
        $criteria->compare('t.size_right', $query, true, 'OR');
        $criteria->compare('t.urk_left', $query, true, 'OR');
        $criteria->compare('t.urk_right', $query, true, 'OR');
        $criteria->compare('material.title', $query, true, 'OR');
        $criteria->compare('t.height_left', $query, true, 'OR');
        $criteria->compare('t.height_right', $query, true, 'OR');
        $criteria->compare('t.top_volume_left', $query, true, 'OR');
        $criteria->compare('t.top_volume_right', $query, true, 'OR');
        $criteria->compare('t.ankle_volume_left', $query, true, 'OR');
        $criteria->compare('t.ankle_volume_right', $query, true, 'OR');
        $criteria->compare('t.kv_volume_left', $query, true, 'OR');
        $criteria->compare('t.kv_volume_right', $query, true, 'OR');
        $criteria->compare('customer_surname', $query, true, 'OR');
        $criteria->compare('customer_name', $query, true, 'OR');
        $criteria->compare('customer_patronymic', $query, true, 'OR');
        $criteria->compare('user.surname', $query, true, 'OR');
        $criteria->compare('user.name', $query, true, 'OR');
        $criteria->compare('user.patronymic', $query, true, 'OR');
        $criteria->compare('t.comment', $query, true, 'OR');

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => false,
        ]);
    }

}
