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
            ['description, comment', 'safe'],
            ['picture', 'file', 'types' => 'jpg, jpeg, gif, png', 'allowEmpty' => true],
            ['picture', 'default', 'value' => 'ortho.jpg'],
            ['id, name, description, comment, date_created, date_modified, author_id, modified_by', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'editor' => [self::BELONGS_TO, 'User', 'modified_by'],
            'author' => [self::BELONGS_TO, 'User', 'author_id'],
            'orders' => [self::HAS_MANY, 'Order', 'model_id', 'order' => 'date_created DESC', 'condition' => 'is_deleted=0'],
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

    public function attributeLabels()
    {
        return [
            'name' => 'Название модели',
            'description' => 'Описание модели',
            'picture' => 'Изображение модели',
            'comment' => 'Комментарий',
            'date_created' => 'Дата создания',
            'author_id' => 'Автор',
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

    protected function beforeSave()
    {
        /** @var  $purifier CHtmlPurifier */
        $purifier = new CHtmlPurifier();
        $this->description = $purifier->purify($this->description);
        $this->comment = $purifier->purify($this->comment);

        return parent::beforeSave();
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->with = ['author'];
        $criteria->compare('id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('author.surname', $this->author_id, true, 'OR');
        $criteria->compare('author.name', $this->author_id, true, 'OR');
        $criteria->compare('author.patronymic', $this->author_id, true, 'OR');
        $criteria->compare('date_created', $this->date_created);
        $criteria->compare('t.is_deleted', 0);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => [
                    'date_created' => 'desc',
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
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
        return 'Найденные модели:';
    }

    public function viewDir()
    {
        return 'model';
    }

    public function siteSearch($query)
    {
        $criteria = new CDbCriteria;

        $criteria->with = ['author'];

        $criteria->compare('t.name', $query, true, 'OR');
        $criteria->compare('description', $query, true, 'OR');
        $criteria->compare('t.comment', $query, true, 'OR');
        $criteria->compare('author.surname', $this->author_id, true, 'OR');
        $criteria->compare('author.name', $this->author_id, true, 'OR');
        $criteria->compare('author.patronymic', $this->author_id, true, 'OR');
        $criteria->compare('t.is_deleted', 0);
        $criteria->order = 't.date_created desc';
        $criteria->limit = 1000;

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => false,
        ]);
    }

    /**
     * Выгрузка для отчета
     * @param $from
     * @param $to
     * @return mixed
     */
    public static function report($from, $to)
    {
        return Yii::app()->db->createCommand()
            ->select([
                'm.name as Модель',
                'm.description as Описание',
                'm.comment as Комментарий',
                'CONCAT_WS(" ", u.surname, u.name, u.patronymic) as Автор',
                'm.date_created as Дата создания',
                'm.is_deleted as Удалено',
            ])
            ->from(self::tableName() . ' m')
            ->join('users u', 'u.id = m.author_id')
            ->where('m.date_created BETWEEN "' . $from . '" AND "' . $to . '"')
            ->order('m.date_created desc')
            ->queryAll();
    }

}
