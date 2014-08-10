<?php

class ModelController extends Controller
{
    public $layout = '//layouts/column1';

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
                'actions' => ['create', 'index', 'view'],
                'users' => ['*'],
            ],
            ['allow',
                'actions' => ['delete', 'update'],
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
                'modelClass' => 'Models',
                'redirectTo' => 'index',
            ],
        ];
    }

    public function actionView($id)
    {
        $this->render('view', [
            'model' => $this->loadModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Models();

        if (isset($_POST['Models'])) {
            $model->attributes = $_POST['Models'];

            $uploader = CUploadedFile::getInstance($model, 'picture');
            $fileName = 'ortho.jpg';

            if ($uploader !== null) {
                $fileName = time() . '_' . $uploader->getName();
                $model->picture = $fileName; // в базу пишется только имя файла, не путь!
            } else {
                $model->picture = $fileName;
            }

            if ($model->save()) {
                if ($uploader)
                    $uploader->saveAs(Yii::getPathOfAlias('webroot') . Models::MODEL_IMAGE_PATH . $fileName);
                $this->redirect(['index']);
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Models'])) {
            $model->attributes = $_POST['Models'];
            if ($model->save())
                $this->redirect(['view', 'id' => $model->id]);
        }

        $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        $model = new Models('search');
        $model->unsetAttributes();
        if (isset($_GET['Models']))
            $model->attributes = $_GET['Models'];

        $this->render('index', [
            'model' => $model,
        ]);
    }

    public function loadModel($id)
    {
        $model = Models::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
