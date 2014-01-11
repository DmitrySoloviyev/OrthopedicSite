<?php

/**
 * This is the model class for table "Materials".
 *
 * The followings are the available columns in table 'Materials':
 * @property integer $MaterialID
 * @property string $MaterialValue
 *
 * The followings are the available model relations:
 * @property Orders[] $orders
 */
class Materials extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Materials';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('MaterialID, MaterialValue', 'required', 'on'=>'insert'),
			array('MaterialValue', 'required', 'on'=>'add'),
			array('MaterialValue', 'length', 'max'=>30),
			array('MaterialID', 'required', 'on'=>'update'),
			array('MaterialID, MaterialValue', 'safe', 'on'=>'search'),
		);
	}

	public function getMaterialsList(){
		$query = Materials::model()->findAllBySql("SELECT MaterialID, MaterialValue FROM Materials ORDER BY MaterialID");
		$list =  CHtml::listData($query, 'MaterialID', 'MaterialValue');
		return $list;
	}

	public static function getMaterialShortcutList($meterialId){
		$material = Yii::app()->db->createCommand()
		    ->select("MaterialValue AS Material")
		    ->from('Materials')
		    ->where('MaterialID=:id', array(':id'=>$meterialId))
		    ->queryRow();
		return $material['Material'];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'orders' => array(self::HAS_MANY, 'Orders', 'MaterialID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'MaterialID' => 'Материал',
			'MaterialValue' => 'Название материала',
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

		$criteria->compare('MaterialID',$this->MaterialID,true);
		$criteria->compare('MaterialValue',$this->MaterialValue,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Materials the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
