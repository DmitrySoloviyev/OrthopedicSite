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
            'ajaxOnly + GetModelByName, GetModelInfoById',
        ];
    }

    public function actionGetModelByName($term)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, name';
        $criteria->compare('name', $term, true);
        $criteria->compare('is_deleted', 0);
        $models = Models::model()->findAll($criteria);
        $result = [];
        foreach ($models as $model) {
            $result[] = ['id' => $model->id, 'label' => $model->name, 'value' => $model->name];
        }

        echo CJSON::encode($result);
    }

    public function actionGetModelInfoById($id)
    {
        echo CJSON::encode(Models::model()->findByPk($_GET['id']));
    }

}
