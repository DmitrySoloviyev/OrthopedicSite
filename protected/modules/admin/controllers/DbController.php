<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 03.08.14
 * Time: 10:55
 */
class DbController extends Controller
{
    public function actionBackup()
    {
        if (Yii::app()->request->isPostRequest && isset($_POST['backupDbBtn'])) {
            $now = date("_Y-n-d__H-i-s");
            $filename = "BACKUP_ORTHO_DB_" . $now . ".sql";
            $command = "mysqldump --flush-logs --lock-tables --databases -u" . Yii::app()->db->username . " -p" . Yii::app()->db->password . " -hlocalhost ortho_db > $filename";
            $result = system($command);
            if (!$result) {
                header("Content-Type: text/plain;");
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Transfer-Encoding: binary');
                header("Content-Disposition: attachment; filename='$filename'");
                echo file_get_contents($filename);
                unlink($filename);
            }
        } else
            $this->render('backup');
    }

    public function actionRestore()
    {
        $model = new Restore();

        if (isset($_POST['Restore'])) {
            if ($model->validate()) {
                $model->attributes = $_POST['Restore'];
                $model->dump = CUploadedFile::getInstance($model, 'dump');
                $result = Yii::app()->db->createCommand(file_get_contents($model->dump->getTempName()))->execute();
                if ($result == 0) {
                    Yii::app()->user->setFlash('success', "База данных успешно восстановлена из резервной копии!");
                    Yii::app()->cache->flush();
                } else {
                    Yii::app()->user->setFlash('error', "Ошибка восстановления базы данных.");
                }
            }
            $model->unsetAttributes();
        }

        $this->render('restore', [
            'model' => $model,
        ]);
    }

    public function actionOptimize()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $connection = Yii::app()->db;
            $tables = $connection->createCommand("SELECT table_name
                FROM information_schema.tables
                WHERE table_schema='ortho_db' AND table_name <> 'tbl_migration'")
                ->queryAll();

            foreach ($tables as $table) {
                $connection->createCommand('OPTIMIZE TABLE ' . $table['table_name'])->execute();
            }
            Yii::app()->end();
        } else
            $this->render('optimize');
    }

}
