<?php

class UserController extends Controller
{
    public function filters()
    {
        return [
            'postOnly + create, delete',
        ];
    }

    public function actionCreate()
    {
        if (isset($_POST['Employee'])) {
            $name = mb_convert_case(trim($_POST['Employee']['name']), MB_CASE_TITLE, 'UTF-8');
            $surname = mb_convert_case(trim($_POST['Employee']['surname']), MB_CASE_TITLE, 'UTF-8');
            $patronymic = mb_convert_case(trim($_POST['Employee']['patronymic']), MB_CASE_TITLE, 'UTF-8');

            // если такой модельер уже есть - восстанавливаем
            $employeeExists = Employee::model()->findByAttributes([
                'name' => $name,
                'surname' => $surname,
                'patronymic' => $patronymic,
            ]);
            if ($employeeExists) {
                $employeeExists->is_deleted = 0;
                if ($employeeExists->save(false)) {
                    Yii::app()->user->setFlash('success', 'Модельер ' . $employeeExists->fullName() . ' успешно восстановлен!');
                } else {
                    Yii::app()->user->setFlash('error', "Ошибка при сохранении модельера!");
                }
            } else {
                $employee = new Employee();
                $employee->setAttributes([
                    'name' => $name,
                    'surname' => $surname,
                    'patronymic' => $patronymic,
                ], false);
                if ($employee->save()) {
                    Yii::app()->user->setFlash('success', "Новый модельер " . $employee->fullName() . " успешно добавлен!");
                } else {
                    Yii::app()->user->setFlash('error', "Ошибка при сохранении модельера!");
                }
            }
        }

        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionDelete()
    {
        if (isset($_POST['Employee'])) {
            $id = (int)trim($_POST['Employee']['id']);
            $toDelete = Employee::model()->findByPk($id);
            if ($toDelete) {
                $toDelete->is_deleted = 1;
                if ($toDelete->save(false)) {
                    Yii::app()->user->setFlash('success', "Модельер успешно удален!");
                } else {
                    Yii::app()->user->setFlash('error', "Ошибка удаления модельера!");
                }
            } else {
                Yii::app()->user->setFlash('error', "Модельер не найден!");
            }
        }

        Yii::app()->request->redirect(Yii::app()->createUrl('admin/index'));
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }

        $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
