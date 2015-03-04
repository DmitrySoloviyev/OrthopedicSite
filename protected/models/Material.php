<?php

/**
 * This is the model class for table "materials".
 *
 * The followings are the available columns in table 'materials':
 *
 * @property integer $id
 * @property string $title
 * @property integer $author_id
 * @property integer $modified_by
 * @property string $date_created
 * @property string $date_modified
 * @property boolean $is_deleted
 *
 * The followings are the available model relations:
 * @property User $editor
 * @property User $author
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
            ['title', 'length', 'max' => 255],
            ['id, title, date_created, date_modified, author_id, modified_by', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'ordersMaterials' => [self::HAS_MANY, 'OrdersMaterials', 'material_id'],
            'editor' => [self::BELONGS_TO, 'User', 'modified_by'],
            'author' => [self::BELONGS_TO, 'User', 'author_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Материал',
            'date_created' => 'Дата создания',
            'author_id' => 'Автор',
            'modified_by' => 'Изменил',
            'date_modified' => 'Дата изменения',
        ];
    }

    public function behaviors()
    {
        return [
            'CommonBehavior' => [
                'class' => 'CommonBehavior',
            ],
            'DateTimeFormatBehavior' => [
                'class' => 'DateTimeFormatBehavior',
            ],
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

        return $this->save(false);
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('author_id', $this->author_id);
        $criteria->compare('modified_by', $this->modified_by);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_modified', $this->date_modified, true);
        $criteria->compare('is_deleted', 0);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

}
