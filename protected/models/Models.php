<?php

/**
 * This is the model class for table "models".
 *
 * The followings are the available columns in table 'models':
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $picture
 * @property string $comment
 * @property string $created_by
 * @property string $modified_by
 * @property string $date_created
 * @property string $date_modified
 * @property boolean $is_deleted
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Models extends CActiveRecord
{
    const MODEL_IMAGE_PATH = '/upload/OrthopedicGallery/';

    public function tableName()
    {
        return 'models';
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'unique'],
            ['name', 'length', 'max' => 6],
            ['is_deleted', 'boolean'],
            ['description, comment', 'length', 'max' => 255],
            ['picture', 'file', 'types' => 'jpg, jpeg, gif, png', 'allowEmpty' => true],
            ['id, name, description, comment, date_created, date_modified, created_by, modified_by', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'orders' => [self::HAS_MANY, 'Order', 'model_id'],
        ];
    }

    public function beforeSave()
    {
        if (empty($this->picture)) {
            $this->picture = 'ortho.jpg';
        }
        if ($this->isNewRecord) {
            $this->date_created = new CDbExpression('NOW()');
        }
        $this->date_modified = new CDbExpression('NOW()');

        return parent::beforeSave();
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название модели',
            'description' => 'Описание модели',
            'picture' => 'Изображение модели',
            'comment' => 'Комментарий',
            'date_created' => 'Дата создания',
            'created_by' => 'Автор',
            'modified_by' => 'Изменил',
            'date_modified' => 'Дата изменения',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, false);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_modified', $this->date_modified, true);
        $criteria->compare('is_deleted', 0);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => [
                    'date_created' => 'desc',
                ],
            ],
        ]);
    }

    /**
     * Сохраняет изображение модели
     * @param $extension
     * @return string
     */
    public function savePicture($extension)
    {
        $fileName = 'model_id_' . $this->id . '.' . $extension;
        $this->picture = $fileName; // в базу пишется только имя файла, не путь!
        $filePath = Yii::getPathOfAlias('webroot') . self::MODEL_IMAGE_PATH . $fileName;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $this->save(false);

        return $filePath;
    }


    public function showSearchResults()
    {
        echo 'Найденные модели:';
    }

    public function viewDir()
    {
        return 'model';
    }

    public function siteSearch($query)
    {
        $criteria = new CDbCriteria;

        $criteria->compare('name', $query, true, 'OR');
        $criteria->compare('description', $query, true, 'OR');
        $criteria->compare('picture', $query, true, 'OR');
        $criteria->compare('t.comment', $query, true, 'OR');

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => false,
        ]);
    }

}
