<?php

class UserController extends Controller
{
    public function accessRules()
    {
        return [
            ['allow',
                'actions' => ['index', 'delete', 'create', 'update'],
                'users' => ['admin'],
            ],
            ['deny',
                'users' => ['*'],
            ],
        ];
    }

    public function actions()
    {
        return [
            'delete' => [
                'class' => 'DeleteAction',
                'modelClass' => 'User',
                'redirectTo' => 'index',
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new User();

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save())
                $this->redirect(['index']);
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save())
                $this->redirect(['index']);
        }

        $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        $model = new User('search');
        $model->unsetAttributes();
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('index', [
            'model' => $model,
        ]);
    }

    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
