<?php

/**
 * This is the model class for table "employees".
 *
 * The followings are the available columns in table 'employees':
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
//    public $FIO;

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
            'is_deleted' => 'Статус',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
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


    public function employeeList()
    {
        $employees = self::model()->findAll('is_deleted = ' . 0);

        return CHtml::listData($employees, 'id', function($employee){
            return $employee->fullName();
        });
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

}
