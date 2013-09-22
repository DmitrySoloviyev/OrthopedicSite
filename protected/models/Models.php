<?php

/**
 * This is the model class for table "Models".
 *
 * The followings are the available columns in table 'Models':
 * @property string $ModelID
 * @property string $ModelName
 * @property string $ModelDescription
 * @property string $ModelPicture
 * @property string $DateModified
 *
 * The followings are the available model relations:
 * @property Orders[] $orders
 */
class Models extends CActiveRecord
{
	public $isNewModel;
	public $basedID;
	public $loadImage;

	public $ModelIDUpdate;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Models';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ModelName', 'required', 'on'=>'insert'),
			array('ModelID', 'safe'),
			array('ModelName', 'length', 'max'=>6, 'on'=>'insert'),
			array('ModelDescription', 'length', 'max'=>255),
			array('ModelPicture', 'length', 'max'=>255),
			array('loadImage', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
			array('basedID', 'safe'),
			array('isNewModel', 'boolean'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ModelID, ModelName, ModelDescription, Author, ModelPicture, DateModified', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Orders', 'ModelID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ModelID' => 'Model',
			'ModelName' => 'Модель',
			'ModelDescription' => 'Model Description',
			'ModelPicture' => 'Model Picture',
			'DateModified' => 'Date Modified',
			'isNewModel'=>'Новая модель',
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

		$criteria->compare('ModelID',$this->ModelID,true);
		$criteria->compare('ModelName',$this->ModelName,true);
		$criteria->compare('ModelDescription',$this->ModelDescription,true);
		$criteria->compare('ModelPicture',$this->ModelPicture,true);
		$criteria->compare('DateModified',$this->DateModified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Models the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getModelNames($name)
    {
	   	$criteria = new CDbCriteria;
		$criteria->select='ModelName';
		$criteria->condition='ModelName LIKE :ModelName';
		$criteria->params=array(':ModelName'=>'%'.$name.'%');
		$modelNames = $this->findAll($criteria);
		$result = array();
		foreach ($modelNames as $name)
		{
			$result[] = array('label'=>$name->ModelName, 'value'=>$name->ModelName);
		}
		return json_encode($result);
    }

    public function getModels($name)
    {
		$criteria = new CDbCriteria;
		$criteria->select='ModelID, ModelName, ModelDescription, ModelPicture, DateModified';
		$criteria->condition='ModelName=:name';
		$criteria->params=array(':name'=>$name);

		$count = $this->count($criteria);

		if($count == 0)
			return json_encode(array('null'=>null, 'null'=>null));

		$searchModels = $this->findAll($criteria);

		$result = array();
		foreach ($searchModels as $modelItem)
		{
			$result[] = array('ModelID'=>$modelItem->ModelID, 
					'ModelName'=>$modelItem->ModelName,
					'ModelDescription'=>$modelItem->ModelDescription,
					'ModelPicture'=>$modelItem->ModelPicture,
					'DateModified'=>$modelItem->DateModified
				);
		}
		return json_encode($result);
    }

    public function getModelById($id)
    {
		$criteria = new CDbCriteria;
		$criteria->select='ModelID, ModelName, ModelDescription, ModelPicture, DateModified';
		$criteria->condition='ModelID=:id';
		$criteria->params=array(':id'=>$id);

		$searchModels = $this->findAll($criteria);

		$result = array();
		foreach ($searchModels as $modelItem)
		{
			$result[] = array('ModelID'=>$modelItem->ModelID, 
					'ModelName'=>$modelItem->ModelName,
					'ModelDescription'=>$modelItem->ModelDescription,
					'ModelPicture'=>$modelItem->ModelPicture,
					'DateModified'=>$modelItem->DateModified
				);
		}
		return json_encode($result);
    }

    public function GetAllModels()
    {
    	$criteria = new CDbCriteria;
		$criteria->select='ModelID, ModelName, ModelDescription, ModelPicture, DateModified';
		
		$searchModels = $this->findAll($criteria);

		$result = array();
		foreach ($searchModels as $modelItem)
		{
			$result[] = array('ModelID'=>$modelItem->ModelID, 
					'ModelName'=>$modelItem->ModelName,
					'ModelDescription'=>$modelItem->ModelDescription,
					'ModelPicture'=>$modelItem->ModelPicture,
					'DateModified'=>$modelItem->DateModified
				);
		}
		return json_encode($result);
    }
}