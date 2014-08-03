<?php

class MaterialController extends Controller
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
                'modelClass' => 'Material',
                'redirectTo' => 'index',
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Material();

        if (isset($_POST['Material'])) {
            $model->attributes = $_POST['Material'];
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

        if (isset($_POST['Material'])) {
            $model->attributes = $_POST['Material'];
            if ($model->save())
                $this->redirect(['index']);
        }

        $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        $model = new Material('search');
        $model->unsetAttributes();
        if (isset($_GET['Material']))
            $model->attributes = $_GET['Material'];

        $this->render('index', [
            'model' => $model,
        ]);
    }

    public function loadModel($id)
    {
        $model = Material::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
