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
            'ajaxOnly + getmodels, nextmodel, prevmodel',
        ];
    }

    public function actionGetModels($term)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'name';
        $criteria->condition = 'name LIKE :name';
        $criteria->params = [':name' => '%' . $term . '%'];
        $models = Models::model()->findAll($criteria);
        $result = [];
        foreach ($models as $model) {
            $result[] = ['label' => $model->name, 'value' => $model->name];
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

//        $this->renderPartial('/order/_model', ['model' => $model], false, true);
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

//        $this->renderPartial('/order/_model', ['model' => $model], false, true);
        echo CJSON::encode($model);
    }

}
