<?php

/**
 * This is the model class for table "Urk".
 *
 * The followings are the available columns in table 'Urk':
 * @property string $UrkID
 * @property integer $UrkValue
 *
 * The followings are the available model relations:
 * @property Orders[] $orders
 * @property Orders[] $orders1
 */
class Urk extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Urk';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UrkID, UrkValue', 'required'),
			array('UrkValue', 'numerical', 'integerOnly'=>true),
			array('UrkID', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('UrkID, UrkValue', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Orders', 'UrkLEFT'),
			'orders1' => array(self::HAS_MANY, 'Orders', 'UrkRIGHT'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'UrkID' => 'Urk',
			'UrkValue' => 'Urk Value',
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

		$criteria->compare('UrkID',$this->UrkID,true);
		$criteria->compare('UrkValue',$this->UrkValue);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Urk the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
