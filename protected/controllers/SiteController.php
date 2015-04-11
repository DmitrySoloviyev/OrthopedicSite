<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 05.08.14
 * Time: 0:36
 */
class SiteController extends Controller
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
                'actions' => ['search'],
                'users' => ['@'],
            ],
            ['allow',
                'actions' => ['index', 'about', 'error'],
                'users' => ['*'],
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

    public function actionAbout()
    {
        $this->render('about');
    }

    public function actionSearch()
    {
        $searchQuery = Yii::app()->request->getParam('search', false);
        $results = [];

        if ($searchQuery) {
            $searchForm = new SearchForm();
            $searchForm->query = $searchQuery;
            $results = $searchForm->search();
        }

        $this->render('search_results', ['query' => $searchQuery, 'results' => $results]);
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
