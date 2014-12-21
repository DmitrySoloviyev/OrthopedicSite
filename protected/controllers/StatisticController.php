<?php

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
                'actions' => ['index'],
                'users' => ['@'],
            ],
            ['deny',
                'users' => ['*'],
            ],
        ];
    }

    public function actionIndex()
    {
        $ordersPerDay = new OrdersPerDay('Общая оценка производительности: количество заказов по дням недели');
        $employeesByOrdersPerDay = new EmployeesByOrdersPerDay('Оценка производительности модельеров по дням недели');
        $ordersPie = new EmployeesPieByOrders('Объем реализованных заказов по модельерам за последние 3 месяца');

        $this->render('index', [
            'ordersPerDay' => $ordersPerDay,
            'ordersPie' => $ordersPie,
            'employeesByOrdersPerDay' => $employeesByOrdersPerDay,
        ]);
    }

}
