<?php

class MaterialController extends Controller
{
    public function filters()
    {
        return [
            'postOnly + create',
        ];
    }

	public function actionCreate()
	{
        if (isset($_POST['Material'])) {
            $material = new Material();
            $material->material = mb_convert_case(trim($_POST['Material']['material']), MB_CASE_TITLE, 'UTF-8');
            if ($material->save()) {
                Yii::app()->user->setFlash('success', "Материал " . $material->material . " успешно добавлен!");
            } else {
                Yii::app()->user->setFlash('error', "Ошибка при добавлении нового материала!");
            }
            $material->unsetAttributes();
        }

        Yii::app()->request->redirect(Yii::app()->createUrl('admin/index'));
	}

}
