<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 22.02.15
 * Time: 0:53
 */
class CommonBehavior extends CActiveRecordBehavior
{
    public $date_created = 'date_created';
    public $date_modified = 'date_modified';
    public $author_id = 'author_id';
    public $modified_by = 'modified_by';

    public function beforeSave($event)
    {
        if ($this->getOwner()->isNewRecord) {
            $this->getOwner()->{$this->date_created} = new CDbExpression('NOW()');
            $this->getOwner()->{$this->author_id} = Yii::app()->user->id;
        }
        $this->getOwner()->{$this->date_modified} = new CDbExpression('NOW()');
        $this->getOwner()->{$this->modified_by} = Yii::app()->user->id;

        return parent::beforeSave($event);
    }


    public function isDeletedLabel()
    {
        return $this->getOwner()->is_deleted ? 'Удалено' : 'Нет';
    }

}
