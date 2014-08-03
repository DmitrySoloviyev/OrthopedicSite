<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 18.03.14
 * Time: 21:34
 */
class AjaxController extends Controller
{
    public function filters()
    {
        return [
            'ajaxOnly + getmodels, nextmodel, prevmodel, GetModelInfoById',
        ];
    }

    public function actionGetModels($term)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, name';
        $criteria->condition = 'name LIKE :name';
        $criteria->params = [':name' => '%' . $term . '%'];
        $models = Models::model()->findAll($criteria);
        $result = [];
        foreach ($models as $model) {
            $result[] = ['id' => $model->id, 'label' => $model->name, 'value' => $model->name];
        }

        echo CJSON::encode($result);
    }

    public function actionPrevModel()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'id < :id AND name = :name';
        $criteria->params = [':id' => $_GET['id'], ':name' => $_GET['name']];
        $criteria->limit = 1;
        $model = Models::model()->find($criteria);
        if (!$model) {
            $model = Models::model()->findByPk($_GET['id']);
        }

        echo CJSON::encode($model);
    }

    public function actionNextModel()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'id > :id AND name = :name';
        $criteria->params = [':id' => $_GET['id'], ':name' => $_GET['name']];
        $criteria->limit = 1;
        $model = Models::model()->find($criteria);
        if (!$model) {
            $model = Models::model()->findByPk($_GET['id']);
        }

        echo CJSON::encode($model);
    }

    public function actionGetModelInfoById($id)
    {
//        $criteria = new CDbCriteria;
//        $criteria->condition = 'name = :name';
//        $criteria->params = [':name' => $_GET['name']];
//        $criteria->limit = 1;
//        $model = Models::model()->findByPk($id);

        echo CJSON::encode(Models::model()->findByPk($_GET['id']));
    }

}
