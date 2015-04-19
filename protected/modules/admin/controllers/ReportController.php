<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 03.08.14
 * Time: 11:02
 */
class ReportController extends Controller
{
    public function actionOrders()
    {
        $report = new Report();

        if (isset($_POST['Report'])) {
            $report->attributes = $_POST['Report'];
            $report->generateByOrders();
        }

        $this->render('orders', ['report' => $report]);
    }

    public function actionModels()
    {
        $report = new Report();

        if (isset($_POST['Report'])) {
            $report->attributes = $_POST['Report'];
            $report->generateByModels();
        }

        $this->render('models', ['report' => $report]);
    }

}
