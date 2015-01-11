<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 05.08.14
 * Time: 0:36
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionAbout()
    {
        $this->render('about');
    }

    public function actionSearch()
    {
        if (isset($_GET['SearchForm'])) {
            $searchForm = new SearchForm();
            $searchForm->attributes = $_GET['SearchForm'];
            $results = $searchForm->search();

            $this->render('search_results', ['query' => $searchForm->query, 'results' => $results]);
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
