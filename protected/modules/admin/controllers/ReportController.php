<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 03.08.14
 * Time: 11:02
 */
class ReportController extends Controller
{
    public function actionIndex()
    {
        $report = new Report();

        if (isset($_POST['Report'])) {
            $report->attributes = $_POST['Report'];
            $report->generateMain();
        }

        $this->render('index', ['report' => $report]);
    }

}
