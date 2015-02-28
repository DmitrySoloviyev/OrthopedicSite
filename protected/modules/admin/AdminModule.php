<?php

class AdminModule extends CWebModule
{
    public function init()
    {
        $this->setImport([
            'admin.models.*',
            'admin.components.*',
        ]);

        Yii::app()->setComponents([
            'errorHandler' => [
                'errorAction' => '/admin/default/error',
            ],
        ]);
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else {
            return false;
        }
    }

}
