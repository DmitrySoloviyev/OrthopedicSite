<?php

class OrderController extends Controller
{
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
                'modelClass' => 'Order',
                'redirectTo' => 'index',
            ],
        ];
    }

    public function actionCreate()
    {
        $order = new Order();
        $customer = new Customer();

        if (isset($_POST['Order'])) {
            $order->attributes = $_POST['Order'];
            $customer->attributes = $_POST['Customer'];
            $transaction = Yii::app()->db->beginTransaction();

            if (!$customer->save()) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', 'Ошибка при сохранении заказчика!');

                return;
            }
            $order->customer_id = $customer->id;

            if ($order->save()) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', 'Новый заказ успешно добавлен!');
                $this->redirect('create');
            } else {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', 'Ошибка при добавлении заказа!', $order->getErrors());
            }
        }

        $this->render('create', [
            'order' => $order,
            'customer' => $customer,
        ]);
    }

    public function actionIndex()
    {
        $order = new Order('search');
        $order->unsetAttributes();
/*
        if (!empty($_GET['quickSearch'])) {
            $order->order_id = $_GET['quickSearch'];
            $order->model_id = $_GET['quickSearch'];
            $order->employee_id = $_GET['quickSearch'];
            $order->material_id = $_GET['quickSearch'];
        }
*/
        if (isset($_GET['Order']))
            $order->attributes = $_GET['Order'];

        $this->render('index', [
            'order' => $order
        ]);
    }

    public function actionView($id)
    {
        $this->render('view', [
            'order' => $this->loadModel($id),
        ]);
    }

    public function actionUpdate($id)
    {
        $order = $this->loadModel($id);

        if (isset($_POST['Order'])) {

        }

        $this->render('update', [
            'model' => $order,
        ]);
    }


    public function loadModel($id)
    {
        // TODO искать по первичному ключу и где is_deleted = 0 (относится и к остальным моделям)
        $model = Order::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

}
