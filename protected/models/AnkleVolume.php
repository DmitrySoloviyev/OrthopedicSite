<?php

/**
 * This is the model class for table "AnkleVolume".
 *
 * The followings are the available columns in table 'AnkleVolume':
 * @property string $AnkleVolumeID
 * @property double $AnkleVolumeValue
 *
 * The followings are the available model relations:
 * @property Orders[] $orders
 * @property Orders[] $orders1
 */
class AnkleVolume extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'AnkleVolume';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('AnkleVolumeID, AnkleVolumeValue', 'required'),
			array('AnkleVolumeValue', 'numerical'),
			array('AnkleVolumeID', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('AnkleVolumeID, AnkleVolumeValue', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Orders', 'AnkleVolumeLEFT'),
			'orders1' => array(self::HAS_MANY, 'Orders', 'AnkleVolumeRIGHT'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'AnkleVolumeID' => 'Ankle Volume',
			'AnkleVolumeValue' => 'Ankle Volume Value',
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

		$criteria->compare('AnkleVolumeID',$this->AnkleVolumeID,true);
		$criteria->compare('AnkleVolumeValue',$this->AnkleVolumeValue);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AnkleVolume the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
