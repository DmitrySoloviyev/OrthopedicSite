<?php

/**
 * This is the model class for table "models".
 *
 * The followings are the available columns in table 'models':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $picture
 * @property string $date_created
 * @property string $date_modified
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Model extends CActiveRecord
{
    public $isNewModel;
    public $basedID;
    public $loadImage;
    public $ModelIDUpdate;

    public function tableName()
    {
        return 'models';
    }

    public function rules()
    {
        return [
            ['name, description', 'required'],
            ['name', 'length', 'max' => 6],
            ['description, picture', 'length', 'max' => 255],
            ['picture', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true],
            ['id, name, description, picture, date_created, date_modified', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return array(
            'orders' => array(self::HAS_MANY, 'Order', 'model_id'),
        );
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание модели',
            'picture' => 'Изображение модели',
            'date_created' => 'Дата создания',
            'date_modified' => 'Дата изменения',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getModelNames($name)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'ModelName';
        $criteria->condition = 'ModelName LIKE :ModelName';
        $criteria->params = array(':ModelName' => '%' . $name . '%');
        $modelNames = $this->findAll($criteria);
        $result = array();
        foreach ($modelNames as $name) {
            $result[] = array('label' => $name->ModelName, 'value' => $name->ModelName);
        }
        return json_encode($result);
    }

    public function getModels($name)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'ModelID, ModelName, ModelDescription, ModelPicture, DateModified';
        $criteria->condition = 'ModelName=:name';
        $criteria->params = array(':name' => $name);

        $count = $this->count($criteria);

        if ($count == 0)
            return json_encode(array('null' => null, 'null' => null));

        $searchModels = $this->findAll($criteria);

        $result = array();
        foreach ($searchModels as $modelItem) {
            $result[] = array('ModelID' => $modelItem->ModelID,
                'ModelName' => $modelItem->ModelName,
                'ModelDescription' => $modelItem->ModelDescription,
                'ModelPicture' => $modelItem->ModelPicture,
                'DateModified' => $modelItem->DateModified
            );
        }
        return json_encode($result);
    }

    public function getModelById($id)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'ModelID, ModelName, ModelDescription, ModelPicture, DateModified';
        $criteria->condition = 'ModelID=:id';
        $criteria->params = array(':id' => $id);

        $searchModels = $this->findAll($criteria);

        $result = array();
        foreach ($searchModels as $modelItem) {
            $result[] = array('ModelID' => $modelItem->ModelID,
                'ModelName' => $modelItem->ModelName,
                'ModelDescription' => $modelItem->ModelDescription,
                'ModelPicture' => $modelItem->ModelPicture,
                'DateModified' => $modelItem->DateModified
            );
        }
        return json_encode($result);
    }

    public function GetAllModels()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'ModelID, ModelName, ModelDescription, ModelPicture, DateModified';

        $searchModels = $this->findAll($criteria);

        $result = array();
        foreach ($searchModels as $modelItem) {
            $result[] = array('ModelID' => $modelItem->ModelID,
                'ModelName' => $modelItem->ModelName,
                'ModelDescription' => $modelItem->ModelDescription,
                'ModelPicture' => $modelItem->ModelPicture,
                'DateModified' => $modelItem->DateModified
            );
        }
        return json_encode($result);
    }

}
