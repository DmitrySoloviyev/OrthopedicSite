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
 * @property integer $height_left
 * @property integer $height_right
 * @property double $top_volume_left
 * @property double $top_volume_right
 * @property double $ankle_volume_left
 * @property double $ankle_volume_right
 * @property double $kv_volume_left
 * @property double $kv_volume_right
 * @property integer $customer_id
 * @property integer $author_id
 * @property string $comment
 * @property string $date_created
 * @property string $date_modified
 * @property integer $modified_by
 * @property boolean $is_deleted
 *
 * The followings are the available model relations:
 * @property Models $model
 * @property User $author
 * @property User $editor
 * @property Customer $customer
 * @property User $modifiedBy
 */
class Order extends CActiveRecord
{
    public $sizes;
    public $urks;
    public $heights;
    public $top_volumes;
    public $ankle_volumes;
    public $kv_volumes;
    public $ordersMaterials;

    public function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            ['order_name, model_id, ordersHasMaterials, size_left, size_right, urk_left, urk_right, height_left, height_right, top_volume_left, top_volume_right, ankle_volume_left, ankle_volume_right, kv_volume_left, kv_volume_right, customer_id', 'required'],
            ['model_id, customer_id, author_id', 'numerical', 'integerOnly' => true],
            ['size_left, size_right', 'numerical', 'integerOnly' => true, 'min' => 15, 'max' => 49],
            ['urk_left, urk_right', 'numerical', 'integerOnly' => true, 'min' => 100, 'max' => 400],
            ['height_left, height_right', 'numerical', 'integerOnly' => true, 'max' => 40],
            ['height_left, height_right', 'default', 'value' => 0, 'setOnEmpty' => true],
            ['top_volume_left, top_volume_right, ankle_volume_left, ankle_volume_right, kv_volume_left, kv_volume_right', 'numerical', 'integerOnly' => false, 'numberPattern' => '/^\\d\\d(?:\\.[05])?$/'],
            ['order_name', 'unique', 'message' => 'Заказ с таким номером уже существует!'],
            ['order_name', 'length', 'max' => 10],
            ['is_deleted', 'boolean'],
            ['comment', 'safe'],
            ['date_created, date_modified, order_name, ordersMaterials, sizes, urks, heights, top_volumes, ankle_volumes, kv_volumes, model_id, size_left, size_right, urk_left, urk_right, height_left, height_right, top_volume_left, top_volume_right, ankle_volume_left, ankle_volume_right, kv_volume_left, kv_volume_right, customer_id, author_id, comment, is_deleted, modified_by', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'editor' => [self::BELONGS_TO, 'User', 'modified_by'],
            'model' => [self::BELONGS_TO, 'Models', 'model_id'],
            'customer' => [self::BELONGS_TO, 'Customer', 'customer_id'],
            'author' => [self::BELONGS_TO, 'User', 'author_id'],
            'ordersHasMaterials' => [self::MANY_MANY, 'Material', 'orders_materials(order_id,material_id)'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'order_name' => 'Номер заказа',
            'model_id' => 'Модель',
            'ordersMaterials' => 'Материал',
            'ordersHasMaterials' => 'Материал',
            'author_id' => 'Автор',
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

    public function behaviors()
    {
        return [
            'CommonBehavior' => [
                'class' => 'CommonBehavior',
            ],
            'DateTimeFormatBehavior' => [
                'class' => 'DateTimeFormatBehavior',
            ],
        ];
    }

    protected function beforeSave()
    {
        /** @var  $purifier CHtmlPurifier */
        $purifier = new CHtmlPurifier();
        $this->comment = $purifier->purify($this->comment);

        return parent::beforeSave();
    }

    /**
     * Сохранение многое ко многим
     */
    protected function afterSave()
    {
        $orderMaterials = is_object($this->ordersHasMaterials[0]) ? CHtml::listData($this->ordersHasMaterials, 'id', 'id') : $this->ordersHasMaterials;
        OrdersMaterials::model()->deleteAll('order_id=' . $this->id);
        foreach ((array)$orderMaterials as $material_id) {
            $ordersMaterials = new OrdersMaterials();
            $ordersMaterials->order_id = $this->id;
            $ordersMaterials->material_id = $material_id;
            if (!$ordersMaterials->save()) {
                $this->addError('materials', 'Ошибка при сохранении материалов в заказе');
            }
        }

        parent::afterSave();
    }

    public function delete()
    {
        $this->is_deleted = 1;

        return $this->save(false);
    }

    /**
     * Поиск связанных материалов с заказом
     * @param string $separator
     * @return string
     */
    public function materialsList($separator = '<br>')
    {
        $list = '';
        foreach ($this->ordersHasMaterials as $material) {
            $list .= $material->title . $separator;
        }

        return $list;
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = [
            'author', 'customer', 'model', 'ordersHasMaterials'
        ];

        $criteria->compare('order_name', $this->order_name, true);
        $criteria->compare('model.name', $this->model_id, true);

        $criteria->compare('size_left', $this->sizes);
        $criteria->compare('size_right', $this->sizes);

        $criteria->compare('urk_left', $this->urks);
        $criteria->compare('urk_right', $this->urks);

        $criteria->compare('height_left', $this->heights);
        $criteria->compare('height_right', $this->heights);

        $criteria->compare('top_volume_left', $this->top_volumes);
        $criteria->compare('top_volume_right', $this->top_volumes);

        $criteria->compare('ankle_volume_left', $this->ankle_volumes);
        $criteria->compare('ankle_volume_right', $this->ankle_volumes);

        $criteria->compare('kv_volume_left', $this->kv_volumes);
        $criteria->compare('kv_volume_right', $this->kv_volumes);

        $criteria->compare('surname', $this->customer_id);
        $criteria->compare('name', $this->customer_id);
        $criteria->compare('patronymic', $this->customer_id);

        $criteria->compare('author.surname', $this->author_id, true, 'OR');
        $criteria->compare('author.name', $this->author_id, true, 'OR');
        $criteria->compare('author.patronymic', $this->author_id, true, 'OR');

        // фильтр заказов по материалу
        if (isset($this->ordersMaterials)) {
            $ordersMaterials = $this->findByMaterial($this->ordersMaterials);
            $criteria->addInCondition('t.id', CHtml::listData($ordersMaterials, 'order_id', 'order_id'));
        }

        $criteria->compare('t.is_deleted', 0);

        $sort = new CSort();
        $sort->defaultOrder = 't.date_created DESC';
        $sort->attributes = [
            'sizes' => [
                'asc' => 'size_left',
                'desc' => 'size_left desc',
            ],
            'urks' => [
                'asc' => 'urk_left',
                'desc' => 'urk_right desc',
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
            '*',
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
                'o.author_id',
                'CONCAT(u.surname, " ", LEFT(u.name, 1), ".", LEFT(u.patronymic, 1), ".") as user',
            ])
            ->from('orders o')
            ->join('users u', 'u.id = o.author_id')
            ->where('o.is_deleted = 0 AND o.date_created BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()')
            ->group('day_of_month, o.author_id, month_name')
            ->order('o.author_id, o.date_created')
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
            ->join('users u', 'u.id = o.author_id')
            ->where('o.is_deleted = 0 AND o.date_created BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()')
            ->group('o.author_id')
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
        return 'Найденные заказы:';
    }

    public function viewDir()
    {
        return 'order';
    }

    /**
     * Поиск заказов по материалу
     * @param string $materialTitle
     * @return array|CActiveRecord|CActiveRecord[]|mixed|null
     */
    private function findByMaterial($materialTitle = '')
    {
        $materialCriteria = new CDbCriteria();
        $materialCriteria->compare('title', $materialTitle, true);
        $possibleMaterials = Material::model()->findAll($materialCriteria);

        $ordersMaterialsCriteria = new CDbCriteria();
        $ordersMaterialsCriteria->addInCondition('material_id', CHtml::listData($possibleMaterials, 'id', 'id'));
        $ordersMaterials = OrdersMaterials::model()->findAll($ordersMaterialsCriteria);

        return $ordersMaterials;
    }

    public function siteSearch($query)
    {
        $criteria = new CDbCriteria;
        $criteria->with = [
            'author', 'customer', 'model',
        ];
        $criteria->compare('t.order_name', $query, true, 'OR');
        $criteria->compare('t.size_left', $query, true, 'OR');
        $criteria->compare('t.size_right', $query, true, 'OR');
        $criteria->compare('t.urk_left', $query, true, 'OR');
        $criteria->compare('t.urk_right', $query, true, 'OR');
        $criteria->compare('t.height_left', $query, true, 'OR');
        $criteria->compare('t.height_right', $query, true, 'OR');
        $criteria->compare('t.top_volume_left', $query, true, 'OR');
        $criteria->compare('t.top_volume_right', $query, true, 'OR');
        $criteria->compare('t.ankle_volume_left', $query, true, 'OR');
        $criteria->compare('t.ankle_volume_right', $query, true, 'OR');
        $criteria->compare('t.kv_volume_left', $query, true, 'OR');
        $criteria->compare('t.kv_volume_right', $query, true, 'OR');
        $criteria->compare('customer.surname', $query, true, 'OR');
        $criteria->compare('customer.name', $query, true, 'OR');
        $criteria->compare('customer.patronymic', $query, true, 'OR');
        $criteria->compare('author.surname', $query, true, 'OR');
        $criteria->compare('author.name', $query, true, 'OR');
        $criteria->compare('author.patronymic', $query, true, 'OR');
        $criteria->compare('t.comment', $query, true, 'OR');

        $ordersMaterials = $this->findByMaterial($query);
        $criteria->addInCondition('t.id', CHtml::listData($ordersMaterials, 'order_id', 'order_id'), 'OR');
        $criteria->order = 't.date_created desc';
        $criteria->limit = 1000;

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => false,
        ]);
    }

    public function sizesValues($delimiter = ',', $nameLeft = 'левый', $nameRight = 'правый')
    {
        return $this->size_left . ' ' . $nameLeft . $delimiter . ' ' . $this->size_right . ' ' . $nameRight;
    }

    public function urksValues($delimiter = ',', $nameLeft = 'левый', $nameRight = 'правый')
    {
        return $this->urk_left . ' ' . $nameLeft . $delimiter . ' ' . $this->urk_right . ' ' . $nameRight;
    }

    public function heightsValues($delimiter = ',', $nameLeft = 'левый', $nameRight = 'правый')
    {
        return $this->height_left . ' ' . $nameLeft . $delimiter . ' ' . $this->height_right . ' ' . $nameRight;
    }

    public function topVolumesValues($delimiter = ',', $nameLeft = 'левый', $nameRight = 'правый')
    {
        return $this->top_volume_left . ' ' . $nameLeft . $delimiter . ' ' . $this->top_volume_right . ' ' . $nameRight;
    }

    public function ankleVolumesValues($delimiter = ',', $nameLeft = 'левый', $nameRight = 'правый')
    {
        return $this->ankle_volume_left . ' ' . $nameLeft . $delimiter . ' ' . $this->ankle_volume_right . ' ' . $nameRight;
    }

    public function kvVolumesValues($delimiter = ',', $nameLeft = 'левый', $nameRight = 'правый')
    {
        return $this->kv_volume_left . ' ' . $nameLeft . $delimiter . ' ' . $this->kv_volume_right . ' ' . $nameRight;
    }

    /**
     * Выгрузка для отчета
     * @param $from
     * @param $to
     * @return mixed
     */
    public static function report($from, $to)
    {
        $sql = '
            select
                o.id as "order_id",
                o.order_name as "№ Заказа",
                m.id as "model_id",
                m.name as "Модель",
                (
                  select GROUP_CONCAT(mat.title SEPARATOR ", ")
                  from materials mat
                  join orders_materials om on om.material_id=mat.id
                  where om.order_id=o.id
                ) as "Материал",
                o.size_left as "Размер левый",
                o.size_right as "Размер правый",
                o.urk_left as "Урк левый",
                o.urk_right as "Урк правый",
                o.height_left as "Высота левая",
                o.height_right as "Высота правая",
                o.top_volume_left as "Объем верха левый",
                o.top_volume_right as "Объем верха правый",
                o.ankle_volume_left as "Объем лодыжки левый",
                o.ankle_volume_right as "Объем лодыжки правый",
                o.kv_volume_left as "Объем КВ левый",
                o.kv_volume_right as "Объем КВ правый",
                CONCAT_WS(" ", u.surname, u.name, u.patronymic) as "Автор",
                CONCAT_WS(" ", c.surname, c.name, c.patronymic) as "Заказчик",
                o.comment as "Комментарий",
                o.date_created as "Дата создания",
                o.is_deleted as "Удалено"
            from orders o
            join users u on u.id = o.author_id
            join customers c on c.id = o.customer_id
            join models m on m.id = o.model_id
            where o.date_created BETWEEN "' . $from . '" AND "' . $to . '"
            order by o.date_created desc
        ';

        return Yii::app()->db->createCommand($sql)->queryAll();
    }

}
