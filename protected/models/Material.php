<?php

/**
 * This is the model class for table "materials".
 *
 * The followings are the available columns in table 'materials':
 * @property integer $id
 * @property string $material
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Material extends CActiveRecord
{
    public function tableName()
    {
        return 'materials';
    }

    public function rules()
    {
        return [
            ['material', 'required'],
            ['material', 'length', 'max' => 30],
            ['id, material', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'orders' => array(self::HAS_MANY, 'Order', 'material_id'),
        ];
    }

    public function attributeLabels()
    {
        return [
            'material' => 'Материал',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public static function materialList()
    {
        $materials = Yii::app()->redis->getClient()->get('materialsList');
        if ($materials === false) {
            $materials = CHtml::listData(self::model()->findAll(), 'id', CHtml::encode('material'));
            Yii::app()->redis->getClient()->set('materialsList', CJSON::encode($materials));
        } else {
            $materials = CJSON::decode($materials);
        }

        return $materials;
    }

    public static function getMaterialShortcutList($meterialId)
    {
        $material = Yii::app()->db->createCommand()
            ->select("material")
            ->from('materials')
            ->where('id=:id', array(':id' => $meterialId))
            ->queryRow();
        return $material['material'];
    }

    public function afterSave()
    {
        Yii::app()->redis->getClient()->del('materialsList');
    }

}
