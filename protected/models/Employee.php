<?php

/**
 * This is the model class for table "employees".
 *
 * The followings are the available columns in table 'employees':
 *
 * @property integer $id
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 * @property string $date_created
 * @property integer $is_deleted
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Employee extends CActiveRecord
{
    public function tableName()
    {
        return 'employees';
    }

    public function rules()
    {
        return [
            ['surname, name, patronymic', 'required'],
            ['surname, name, patronymic', 'length', 'max' => 30],
            ['is_deleted', 'numerical', 'integerOnly' => true],
            ['id, surname, name, patronymic, date_created, is_deleted', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'orders' => [self::HAS_MANY, 'Order', 'employee_id'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'Модельер',
            'surname' => 'Фамилия модельера',
            'name' => 'Имя модельера',
            'patronymic' => 'Отчество модельера',
            'date_created' => 'Дата регистрации',
            'is_deleted' => 'Уволен',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeValidate()
    {
        $exists = self::model()->findByAttributes([
            'surname' => $this->surname,
            'name' => $this->name,
            'patronymic' => $this->patronymic,
        ]);
        if ($exists)
            $this->addError('', 'Такой модельер уже зарегистрирован в базе. Пожалуйста, укажите другое имя.');

        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->date_created = new CDbExpression('NOW()');
        }

        return parent::beforeSave();
    }

    public function defaultScope()
    {
        return [
            'order' => 'surname',
        ];
    }


    public static function employeeList()
    {
        $employees = Yii::app()->redis->getClient()->get('employeesList');
        if ($employees === false) {
            $employees = CHtml::listData(self::model()->findAll('is_deleted = 0'), 'id', function ($employee) {
                return $employee->fullName();
            });
            Yii::app()->redis->getClient()->set('employeesList', CJSON::encode($employees));
        } else {
            $employees = CJSON::decode($employees);
        }

        return $employees;
    }

    public static function getEmployeeShortcutList($employee_id)
    {
        $employee = Yii::app()->db->createCommand()
            ->select("CONCAT(id, ' ', LEFT(name, 1), '.', LEFT(patronymic, 1), '.') AS Employee")
            ->from('employees')
            ->where('id=:id', [':id' => $employee_id])
            ->queryRow();

        return $employee['Employee'];
    }

    public function fullName()
    {
        return CHtml::encode($this->surname . ' ' . $this->name . ' ' . $this->patronymic);
    }

    public static function searchEmployee($is_deleted = 0)
    {
        $result = self::model()->findAll([
            'select' => 'surname, name, patronymic',
            'condition' => 'is_deleted=:is_deleted',
            'params' => [':is_deleted' => $is_deleted],
        ]);

        $deleted = '';
        foreach ($result as $employee) {
            $deleted .= '<div>' . $employee->fullName() . '</div>';
        }

        return $deleted;
    }

    public function afterSave()
    {
        Yii::app()->redis->getClient()->del('employeesList');

        return parent::afterSave();
    }

    public function afterDelete()
    {
        Yii::app()->redis->getClient()->del('employeesList');

        return parent::afterDelete();
    }

    public function delete()
    {
        $this->is_deleted = 1;

        return $this->save();
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('surname', $this->surname, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('patronymic', $this->patronymic, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('is_deleted', 0);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => [
                    'date_created' => 'desc',
                ],
            ],
        ]);
    }

}
