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
                'modelClass' => 'Order',
                'redirectTo' => 'index',
            ],
        ];
    }

    public function actionCreate()
    {
        $order = new Order();
        $customer = new Customer();

        if (isset($_POST['Order']) && isset($_POST['Customer'])) {
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
        $customer = Customer::model()->findByPk($order->customer_id);

        if (isset($_POST['Order'])) {
            $order->attributes = $_POST['Order'];
            if ($order->save()) {
                Yii::app()->user->setFlash('success', 'Изменения успешно сохранены!');
                $this->redirect(['view', 'id' => $order->id]);
            } else {
                Yii::app()->user->setFlash('error', 'Заказ не обновлен!');
            }
        }

        $this->render('update', [
            'order' => $order,
            'customer' => $customer,
        ]);
    }


    public function loadModel($id)
    {
        $model = Order::model()->findByAttributes(['id' => $id, 'is_deleted' => 0]);
        if ($model === null)
            throw new CHttpException(404, 'Заказ не найден.');
        $model->materials_ids = CHtml::listData(OrdersMaterials::model()->findAll('order_id=' . $model->id), 'material_id', 'material_id');

        return $model;
    }

}
