<?php

/**
 * This is the model class for table "Customers".
 *
 * The followings are the available columns in table 'Customers':
 * @property string $CustomerID
 * @property string $CustomerSN
 * @property string $CustomerFN
 * @property string $CustomerP
 *
 * The followings are the available model relations:
 * @property Orders[] $orders
 */
class Customers extends CActiveRecord
{
	public $CustomerSNUpdate;
	public $CustomerFNUpdate;
	public $CustomerPUpdate;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Customers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CustomerSN, CustomerFN, CustomerP', 'required', 'on'=>'insert'),
			array('CustomerSN, CustomerFN, CustomerP', 'length', 'max'=>30),
			array('CustomerSNUpdate, CustomerFNUpdate, CustomerPUpdate', 'required', 'on'=>'update'),
			array('CustomerID, CustomerSN, CustomerFN, CustomerP', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Orders', 'CustomerID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'CustomerID' => 'Customer',
			'CustomerSN' => 'Фамилия заказчика',
			'CustomerFN' => 'Имя заказчика',
			'CustomerP' => 'Отчество заказчика',
			'CustomerSNUpdate' => 'Фамилия заказчика',
			'CustomerFNUpdate' => 'Имя заказчика',
			'CustomerPUpdate' => 'Отчество заказчика',
		);
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

		$criteria->compare('CustomerID',$this->CustomerID,true);
		$criteria->compare('CustomerSN',$this->CustomerSN,true);
		$criteria->compare('CustomerFN',$this->CustomerFN,true);
		$criteria->compare('CustomerP',$this->CustomerP,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
