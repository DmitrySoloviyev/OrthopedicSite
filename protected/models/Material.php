<?php

/**
 * This is the model class for table "materials".
 *
 * The followings are the available columns in table 'materials':
 *
 * @property integer $id
 * @property string $title
 * @property boolean $is_deleted
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
            ['title', 'required'],
            ['title', 'unique'],
            ['title', 'length', 'max' => 30],
            ['id, material', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'orders' => [self::HAS_MANY, 'Order', 'material_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Материал',
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
            $materials = CHtml::listData(self::model()->findAll('is_deleted=0'), 'id', CHtml::encode('title'));
            Yii::app()->redis->getClient()->set('materialsList', CJSON::encode($materials));
        } else {
            $materials = CJSON::decode($materials);
        }

        return $materials;
    }

    public static function getMaterialShortcutList($meterialId)
    {
        $material = Yii::app()->db->createCommand()
            ->select('title')
            ->from('materials')
            ->where('id=:id', [':id' => $meterialId])
            ->queryRow();

        return $material['material'];
    }

    public function afterSave()
    {
        Yii::app()->redis->getClient()->del('materialsList');

        return parent::afterSave();
    }

    public function afterDelete()
    {
        Yii::app()->redis->getClient()->del('materialsList');

        return parent::afterDelete();
    }

    public function delete()
    {
        $this->is_deleted = 1;

        return $this->save();
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('is_deleted', 0);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

}
