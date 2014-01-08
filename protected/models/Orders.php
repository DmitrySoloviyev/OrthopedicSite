<?php

/**
 * This is the model class for table "Orders".
 *
 * The followings are the available columns in table 'Orders':
 * @property string $OrderID
 * @property string $ModelID
 * @property string $SizeLEFT
 * @property string $SizeRIGHT
 * @property string $UrkLEFT
 * @property string $UrkRIGHT
 * @property string $MaterialID
 * @property string $HeightLEFT
 * @property string $HeightRIGHT
 * @property string $TopVolumeLEFT
 * @property string $TopVolumeRIGHT
 * @property string $AnkleVolumeLEFT
 * @property string $AnkleVolumeRIGHT
 * @property string $KvVolumeLEFT
 * @property string $KvVolumeRIGHT
 * @property string $CustomerID
 * @property integer $EmployeeID
 * @property string $Date
 * @property string $Comment
 *
 * The followings are the available model relations:
 * @property Models $model
 * @property TopVolume $topVolumeRIGHT
 * @property AnkleVolume $ankleVolumeLEFT
 * @property AnkleVolume $ankleVolumeRIGHT
 * @property KvVolume $kvVolumeLEFT
 * @property KvVolume $kvVolumeRIGHT
 * @property Customers $customer
 * @property Employees $employee
 * @property Sizes $sizeLEFT
 * @property Sizes $sizeRIGHT
 * @property Urk $urkLEFT
 * @property Urk $urkRIGHT
 * @property Materials $material
 * @property Height $heightLEFT
 * @property Height $heightRIGHT
 * @property TopVolume $topVolumeLEFT
 */
/*
 *SN - second name - фамилия
 *FN - first name - имя
 *P - patronymic - отчество
 */
class Orders extends CActiveRecord
{
	/*
	 * INSERT
	 */
	public $OrderID = null;
	public $Size;
	public $Urk;
	public $Height;
	public $TopVolume;
	public $AnkleVolume;
	public $KvVolume;
	public $Comment;

	/*
	 * UPDATE
	 */
	public $OrderIDUpdate;
	public $ModelIDUpdate;
	public $MaterialIDUpdate;
	public $SizeLEFTUpdate;
	public $SizeRIGHTUpdate;
	public $UrkLEFTUpdate;
	public $UrkRIGHTUpdate;
	public $HeightLEFTUpdate;
	public $HeightRIGHTUpdate;
	public $TopVolumeLEFTUpdate;
	public $TopVolumeRIGHTUpdate;
	public $AnkleVolumeLEFTUpdate;
	public $AnkleVolumeRIGHTUpdate;
	public $KvVolumeLEFTUpdate;
	public $KvVolumeRIGHTUpdate;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('OrderID, Size, Urk, Height, TopVolume, AnkleVolume, KvVolume, MaterialID, EmployeeID', 'required', 'on'=>'insert'),
			array('OrderID', 'unique', 'message'=>'Такой заказ уже есть в базе!'),
			array('Size', 'match', 'pattern'=>'/(^(([2-4][0-9])|15|16|17|18|19)$)|(^(([2-4][0-9])|15|16|17|18|19) (([2-4][0-9])|15|16|17|18|19)$)/', 'on'=>'insert'),
			array('Height', 'match', 'pattern'=>'/(^(([1-3][0-9])|0|7|8|9|40)$)|(^(([1-3][0-9])|0|7|8|9|40) (([1-3][0-9])|0|7|8|9|40)$)/', 'on'=>'insert'),
			array('Urk', 'match', 'pattern'=>'/(^([1-3]\\d\\d)|400$)|(^([1-3]\\d\\d)|400 ([1-3]\\d\\d)|400$)/', 'on'=>'insert'),
			array('TopVolume, AnkleVolume', 'match', 'pattern'=>'/(^(([1-4][0-9])|50)(\\.[05])?$)|(^(([1-4][0-9])|50)(\\.[05])? (([1-4][0-9])|50)(\\.[05])?$)/', 'on'=>'insert'),
			array('KvVolume', 'match', 'pattern'=>'/(^(([2-6][0-9])|15|16|17|18|19|70)(\\.[05])?$)|(^(([2-6][0-9])|15|16|17|18|19|70)(\\.[05])? (([2-6][0-9])|15|16|17|18|19|70)(\\.[05])?$)/', 'on'=>'insert'),
			array('Comment', 'length', 'max'=>255),
			array('Date', 'default', 'value'=>new CDbExpression('NOW()')),
			array('OrderIDUpdate, SizeLEFTUpdate, SizeRIGHTUpdate, UrkLEFTUpdate, UrkRIGHTUpdate,
					HeightLEFTUpdate, HeightRIGHTUpdate, TopVolumeLEFTUpdate, TopVolumeRIGHTUpdate, AnkleVolumeLEFTUpdate, AnkleVolumeRIGHTUpdate,
					KvVolumeLEFTUpdate, KvVolumeRIGHTUpdate', 'required', 'on'=>'update'
				),
			array('SizeLEFTUpdate, SizeRIGHTUpdate', 'match', 'pattern'=>'/^(([2-4][0-9])|15|16|17|18|19)$/'),
			array('HeightLEFTUpdate, HeightRIGHTUpdate', 'match', 'pattern'=>'/^(([1-3][0-9])|0|7|8|9|40)$/'),
			array('UrkLEFTUpdate, UrkRIGHTUpdate', 'match', 'pattern'=>'/^([1-3]\\d\\d)|400$/'),
			array('TopVolumeLEFTUpdate, TopVolumeRIGHTUpdate, AnkleVolumeLEFTUpdate, AnkleVolumeRIGHTUpdate', 'match', 'pattern'=>'/^(([1-4][0-9])|50)(\\.[05])?$/'),
			array('KvVolumeLEFTUpdate, KvVolumeRIGHTUpdate', 'match', 'pattern'=>'/^(([2-6][0-9])|15|16|17|18|19|70)(\\.[05])?$/'),
			array('OrderID, Size, Urk, Height, TopVolume, AnkleVolume, KvVolume, EmployeeID, Comment', 'safe', 'on'=>'search'),
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
			'model' 			=> array(self::BELONGS_TO, 'Models', 'ModelID'),
			'topVolumeRIGHT' 	=> array(self::BELONGS_TO, 'TopVolume', 'TopVolumeRIGHT'),
			'ankleVolumeLEFT' 	=> array(self::BELONGS_TO, 'AnkleVolume', 'AnkleVolumeLEFT'),
			'ankleVolumeRIGHT' 	=> array(self::BELONGS_TO, 'AnkleVolume', 'AnkleVolumeRIGHT'),
			'kvVolumeLEFT' 		=> array(self::BELONGS_TO, 'KvVolume', 'KvVolumeLEFT'),
			'kvVolumeRIGHT' 	=> array(self::BELONGS_TO, 'KvVolume', 'KvVolumeRIGHT'),
			'customer' 			=> array(self::BELONGS_TO, 'Customers', 'CustomerID'),
			'employee' 			=> array(self::BELONGS_TO, 'Employees', 'EmployeeID'),
			'sizeLEFT' 			=> array(self::BELONGS_TO, 'Sizes', 'SizeLEFT'),
			'sizeRIGHT' 		=> array(self::BELONGS_TO, 'Sizes', 'SizeRIGHT'),
			'urkLEFT' 			=> array(self::BELONGS_TO, 'Urk', 'UrkLEFT'),
			'urkRIGHT' 			=> array(self::BELONGS_TO, 'Urk', 'UrkRIGHT'),
			'material' 			=> array(self::BELONGS_TO, 'Materials', 'MaterialID'),
			'heightLEFT' 		=> array(self::BELONGS_TO, 'Height', 'HeightLEFT'),
			'heightRIGHT' 		=> array(self::BELONGS_TO, 'Height', 'HeightRIGHT'),
			'topVolumeLEFT' 	=> array(self::BELONGS_TO, 'TopVolume', 'TopVolumeLEFT'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'OrderID' => 'Номер заказа',
			'Size' => 'Размер',
			'Urk' => 'Урк',
			'MaterialID' => 'Материал',
			'Height' => 'Высота',
			'TopVolume' => 'Объем верха',
			'AnkleVolume' => 'Объем лодыжки',
			'KvVolume' => 'Объем КВ',
			'CustomerSN' => 'Фамилия заказчика',
			'CustomerFN' => 'Имя заказчика',
			'CustomerP' => 'Отчество заказчика',
			'EmployeeID' => 'Модельер',
			'Comment' => 'Комментарий',
			'Date' => 'Дата',
			'ModelName' => 'Модель',

			'OrderIDUpdate' => 'Номер заказа',
			'ModelIDUpdate' => 'Модель',
			'MaterialIDUpdate' => 'Материал',
			'SizeLEFTUpdate' => 'Размер левый',
			'SizeRIGHTUpdate' => 'Размер правый',
			'UrkLEFTUpdate' => 'Урк левый',
			'UrkRIGHTUpdate' => 'Урк правый',
			'HeightLEFTUpdate' => 'Высота левый',
			'HeightRIGHTUpdate' => 'Высота правый',
			'TopVolumeLEFTUpdate' => 'Объем верха левый',
			'TopVolumeRIGHTUpdate' => 'Объем верха правый',
			'AnkleVolumeLEFTUpdate' => 'Объем лодыжки левый',
			'AnkleVolumeRIGHTUpdate' => 'Объем лодыжки правый',
			'KvVolumeLEFTUpdate' => 'Объем КВ левый',
			'KvVolumeRIGHTUpdate' => 'Объем КВ правый',
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

		$criteria->compare('OrderID',$this->OrderID,true);
		$criteria->compare('ModelID',$this->ModelID,true);
		$criteria->compare('SizeLEFT',$this->SizeLEFT,true);
		$criteria->compare('SizeRIGHT',$this->SizeRIGHT,true);
		$criteria->compare('UrkLEFT',$this->UrkLEFT,true);
		$criteria->compare('UrkRIGHT',$this->UrkRIGHT,true);
		$criteria->compare('MaterialID',$this->MaterialID,true);
		$criteria->compare('HeightLEFT',$this->HeightLEFT,true);
		$criteria->compare('HeightRIGHT',$this->HeightRIGHT,true);
		$criteria->compare('TopVolumeLEFT',$this->TopVolumeLEFT,true);
		$criteria->compare('TopVolumeRIGHT',$this->TopVolumeRIGHT,true);
		$criteria->compare('AnkleVolumeLEFT',$this->AnkleVolumeLEFT,true);
		$criteria->compare('AnkleVolumeRIGHT',$this->AnkleVolumeRIGHT,true);
		$criteria->compare('KvVolumeLEFT',$this->KvVolumeLEFT,true);
		$criteria->compare('KvVolumeRIGHT',$this->KvVolumeRIGHT,true);
		$criteria->compare('CustomerID',$this->CustomerID,true);
		$criteria->compare('EmployeeID',$this->EmployeeID);
		$criteria->compare('Date',$this->Date,true);
		$criteria->compare('Comment',$this->Comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}