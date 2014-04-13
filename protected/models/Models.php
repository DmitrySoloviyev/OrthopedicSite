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
class Models extends CActiveRecord
{
    public $is_new_model;
    public $loadImage;

    public function tableName()
    {
        return 'models';
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'length', 'max' => 6],
            ['description, picture', 'length', 'max' => 255],
            ['picture', 'file', 'types' => 'jpg, jpeg, gif, png', 'allowEmpty' => true],
            ['id, name, description, picture, date_created, date_modified', 'safe', 'on' => 'search'],
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
        if(empty($this->picture)) {
            $this->picture = '';
        }
        if ($this->isNewRecord) {
            $this->date_created = new CDbExpression('NOW()');
        }
        $this->date_modified = new CDbExpression('NOW()');
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название модели',
            'description' => 'Описание модели',
            'picture' => 'Изображение модели',
            'date_created' => 'Дата создания',
            'date_modified' => 'Дата изменения',
            'is_new_model' => 'Новая модель',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
