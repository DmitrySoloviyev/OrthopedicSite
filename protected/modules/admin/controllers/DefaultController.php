<?php

class DefaultController extends Controller
{
    public $layout = '/layouts/column2';

    public function filters()
    {
        return [
            'accessControl',
        ];
    }

    public function accessRules()
    {
        return [
            ['allow',
                'actions' => ['index'],
                'users' => ['admin'],
            ],
            ['allow',
                'actions' => ['error'],
                'users' => ['@'],
            ],
            ['deny',
                'users' => ['*'],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->render('index');
    }
    public function actionError()
    {
        $this->layout = '//layouts/column1';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}