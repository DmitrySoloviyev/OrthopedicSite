<?php
Yii::import('ext.ortho-graphs.*');

class StatisticController extends Controller
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
                'actions' => ['index', 'ordersPerDay', 'usersByOrdersPerDay', 'ordersPie'],
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


    public function actionOrdersPerDay()
    {
        $ordersPerDay = new OrdersPerDay('Общая оценка производительности: количество заказов по дням недели');

        $this->renderPartial('_orders_per_day', [
            'ordersPerDay' => $ordersPerDay,
        ], false, true);
    }

    public function actionUsersByOrdersPerDay()
    {
        $usersByOrdersPerDay = new UsersByOrdersPerDay('Оценка производительности модельеров по дням недели');

        $this->renderPartial('_users_by_orders_per_day', [
            'usersByOrdersPerDay' => $usersByOrdersPerDay,
        ], false, true);
    }

    public function actionOrdersPie()
    {
        $ordersPie = new UsersPieByOrders('Объем реализованных заказов по модельерам за последние 3 месяца');

        $this->renderPartial('_orders_pie', [
            'ordersPie' => $ordersPie,
        ], false, true);
    }

}
