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
                'actions' => ['create', 'index', 'view', 'feedOrders', 'feedImages'],
                'users' => ['@'],
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
        $model = $this->loadModel($id);
        $this->render('view', [
            'model' => $model,
            'orders' => $model->orders,
        ]);
    }

    public function actionFeedOrders($model_id, $start_order_id)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('model_id=' . $model_id);
        $criteria->addCondition('is_deleted=0');
        $criteria->addCondition('id < ' . $start_order_id);
        $criteria->limit = 10;
        $criteria->order = 'id desc';

        $orders = Order::model()->findAll($criteria);

        echo $this->renderPartial('view/_orders', ['model_id' => $model_id, 'orders' => $orders], true);
    }

    public function actionFeedImages()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('picture!="ortho.jpg"');
        $criteria->addCondition('is_deleted=0');
        $criteria->order = 'id desc';
        $criteria->limit = 10;

        $models = Models::model()->findAll($criteria);
        $items = [];
        if ($models) {
            foreach ($models as $model) {
                /** @var Models $model */
                $items[] = [
                    'url' => Models::MODEL_IMAGE_PATH . $model->picture,
                    'src' => Models::MODEL_IMAGE_PATH . $model->picture,
                    'options' => [
                        'title' => $model->name . ': ' . substr(strip_tags($model->description), 0, 100),
                    ],
                ];
            }
        } else {
            $items[] = [
                'url' => '/upload/OrthopedicGallery/ortho.jpg',
                'src' => '/upload/OrthopedicGallery/ortho.jpg',
                'options' => ['title' => 'Новых изображений моделей не найдено']
            ];
        }

        return $items;
    }

    public function actionCreate()
    {
        $model = new Models();

        if (isset($_POST['Models'])) {
            $model->attributes = $_POST['Models'];
            $uploader = CUploadedFile::getInstance($model, 'picture');

            if ($model->save()) {
                if ($uploader) {
                    $path = $model->savePicture($uploader->extensionName);
                    $uploader->saveAs($path);
                }
                Yii::app()->user->setFlash('success', 'Новая модель успешно добавлена!');
                $this->redirect(['create']);
            } else {
                Yii::app()->user->setFlash('error', 'Ошибка при добавлении модели!', $model->getErrors());
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
            $uploader = CUploadedFile::getInstance($model, 'picture');

            if ($model->save()) {
                if ($uploader) {
                    $path = $model->savePicture($uploader->extensionName);
                    $uploader->saveAs($path);
                }
                Yii::app()->user->setFlash('success', 'Изменения успешно сохранены!');
                $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::app()->user->setFlash('error', 'Модель не обновлена!', $model->getErrors());
            }
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
        $model = Models::model()->findByAttributes(['id' => $id, 'is_deleted' => 0]);
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
