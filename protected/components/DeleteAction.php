<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 26.07.14
 * Time: 0:14
 */

class DeleteAction extends CAction
{
    public $pk = 'id';
    public $modelClass;
    public $redirectTo;

    function run()
    {
        if (empty($_GET[$this->pk])) {
            throw new CHttpException(404);
        }

        $model = CActiveRecord::model($this->modelClass)->findByPk($_GET[$this->pk]);

        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая запись не найдена');

        if ($model->delete())
            $this->controller->redirect($this->redirectTo);

        throw new CHttpException(500);
    }

}
