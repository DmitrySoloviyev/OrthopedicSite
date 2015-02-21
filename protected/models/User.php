<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 *
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 * @property string $date_created
 * @property integer $is_deleted
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class User extends CActiveRecord
{
    public function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            ['surname, name, patronymic, login, password', 'required'],
            ['login', 'unique'],
            ['surname, name, patronymic', 'length', 'max' => 30],
            ['is_deleted', 'numerical', 'integerOnly' => true],
            ['id, surname, name, patronymic, date_created, is_deleted', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'materials' => [self::HAS_MANY, 'Material', 'modified_by'],
            'materials1' => [self::HAS_MANY, 'Material', 'created_by'],
            'models' => [self::HAS_MANY, 'Model', 'modified_by'],
            'models1' => [self::HAS_MANY, 'Model', 'created_by'],
            'orders' => [self::HAS_MANY, 'Order', 'modified_by'],
            'orders1' => [self::HAS_MANY, 'Order', 'user_id'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'Модельер',
            'login' => 'Login',
            'password' => 'Пароль',
            'surname' => 'Фамилия модельера',
            'name' => 'Имя модельера',
            'patronymic' => 'Отчество модельера',
            'date_created' => 'Дата регистрации',
            'is_deleted' => 'Статус',
        ];
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->date_created = new CDbExpression('NOW()');
        }

        $this->password = md5($this->password);

        return parent::beforeSave();
    }

    public static function userList()
    {
        $users = Yii::app()->redis->getClient()->get('usersList');
        if ($users === false) {
            $users = CHtml::listData(self::model()->findAll('is_deleted = 0'), 'id', function ($user) {
                return $user->fullName();
            });
            Yii::app()->redis->getClient()->set('usersList', CJSON::encode($users));
        } else {
            $users = CJSON::decode($users);
        }

        return $users;
    }

    public static function getUserShortcutList($user_id)
    {
        $user = Yii::app()->db->createCommand()
            ->select("CONCAT(id, ' ', LEFT(name, 1), '.', LEFT(patronymic, 1), '.') AS User")
            ->from('users')
            ->where('id=:id', [':id' => $user_id])
            ->queryRow();

        return $user['User'];
    }

    public function fullName()
    {
        return CHtml::encode($this->surname . ' ' . $this->name . ' ' . $this->patronymic);
    }

    public function afterSave()
    {
        Yii::app()->redis->getClient()->del('usersList');

        return parent::afterSave();
    }

    public function afterDelete()
    {
        Yii::app()->redis->getClient()->del('usersList');

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
        $criteria->compare('login', $this->login, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('surname', $this->surname, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('patronymic', $this->patronymic, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('is_deleted', 0);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => [
                    'id' => 'desc',
                ],
            ],
        ]);
    }

    public function isDeletedLabel()
    {
        return $this->is_deleted ? 'Уволен' : 'Работает';
    }

}
