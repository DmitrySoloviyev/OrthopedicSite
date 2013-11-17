<?php

/**
 * This is the model class for table "Employees".
 *
 * The followings are the available columns in table 'Employees':
 * @property integer $EmployeeID
 * @property string $EmployeeSN
 * @property string $EmployeeFN
 * @property string $EmployeeP
 * @property string $STATUS
 *
 * The followings are the available model relations:
 * @property Orders[] $orders
 */
class Employees extends CActiveRecord
{
	public $EmployeeID;
	public $EmployeeFN;
	public $EmployeeSN;
	public $EmployeeP;
	public $FIO;
	public $EmployeeIDUpdate;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Employees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('EmployeeSN, EmployeeFN, EmployeeP, EmployeeID', 'required', 'on'=>'insert'),
			array('EmployeeSN, EmployeeFN, EmployeeP', 'required', 'on'=>'add'),
			array('EmployeeSN, EmployeeFN, EmployeeP', 'length', 'max'=>30),
			array('STATUS', 'length', 'max'=>16, 'allowEmpty'=>true),
			array('EmployeeID', 'required', 'on'=>'update'),
			array('EmployeeID', 'required', 'on'=>'delete'),
			array('EmployeeID, EmployeeSN, EmployeeFN, EmployeeP, STATUS', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'orders' => array(self::HAS_MANY, 'Orders', 'EmployeeID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'EmployeeID' => 'Модельер',
			'EmployeeSN' => 'Фамилия модельера',
			'EmployeeFN' => 'Имя модельера',
			'EmployeeP' => 'Отчество модельера',
			'STATUS' => 'Статус',
		);
	}

	public function getEmployeeList($id = null){
		if($id === null){
			$query = Employees::model()->findAllBySql("SELECT EmployeeID, CONCAT_WS(' ', EmployeeSN, EmployeeFN, EmployeeP) AS FIO FROM Employees WHERE STATUS = 'Работает'");
			$list =  CHtml::listData($query, 'EmployeeID', 'FIO');
			return $list;
		}else{
			$query = Employees::model()->findAllBySql("SELECT EmployeeID, CONCAT_WS(' ', EmployeeSN, EmployeeFN, EmployeeP) AS FIO 
														FROM Employees WHERE STATUS='Работает' OR EmployeeID='".$id."' ");
			$list =  CHtml::listData($query, 'EmployeeID', 'FIO');
			return $list;
		}
	}

	public static function getEmployeeShortcutList($emploee_id){
		$employee = Yii::app()->db->createCommand()
		    ->select("CONCAT(EmployeeSN, ' ', LEFT(EmployeeFN, 1), '.', LEFT(EmployeeP, 1), '.') AS Employee")
		    ->from('Employees')
		    ->where('EmployeeID=:id', array(':id'=>$emploee_id))
		    ->queryRow();
		return $employee['Employee'];
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('EmployeeID',$this->EmployeeID,true);
		$criteria->compare('EmployeeSN',$this->EmployeeSN,true);
		$criteria->compare('EmployeeFN',$this->EmployeeFN,true);
		$criteria->compare('EmployeeP',$this->EmployeeP,true);
		$criteria->compare('STATUS',$this->STATUS,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Employees the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
