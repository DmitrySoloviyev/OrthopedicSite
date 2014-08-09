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

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Благодарю Вас за обращение. Я отвечу вам как можно скорее.');
                $this->refresh();
            }
        }
        $this->render('contact', ['model' => $model]);
    }

}
