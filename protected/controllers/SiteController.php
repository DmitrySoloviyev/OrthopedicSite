<?php

class SiteController extends Controller
{
/* TODO
    public function filters()
    {
        return [
            'accessControl + admin',
        ];
    }

    public function accessRules()
    {
        return [
            ['deny',
                'actions' => ['admin'],
                'roles' => ['admin'],
            ],
        ];
    }*/

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            /*			'captcha'=>[
                            'class'=>'CCaptchaAction',
                            'backColor'=>0xFFFFFF,
                        ],*/
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        //создать БД SHOES если таковой не существует
        try {
            Yii::app()->db->createCommand('SHOW TABLES FROM SHOES')->queryAll();
        } catch (Exception $e) {
            $mysqli = mysqli_connect('localhost', "root", "1111");
            mysqli_query($mysqli, 'CREATE DATABASE SHOES');
            $createDbSql = "mysql -u" . Yii::app()->db->username . " -p" . Yii::app()->db->password . " SHOES < " . Yii::app()->request->baseUrl . "assets/DUMP_DB_SHOES.sql";
            system($createDbSql);
        }
        $employeesModel = new Employees('add');

        if (isset($_POST['Employees'])) {
            $employeesModel->attributes = $_POST['Employees'];

            $employeesModel->EmployeeSN = mb_convert_case(trim($employeesModel->EmployeeSN), MB_CASE_TITLE, 'UTF-8');
            $employeesModel->EmployeeFN = mb_convert_case(trim($employeesModel->EmployeeFN), MB_CASE_TITLE, 'UTF-8');
            $employeesModel->EmployeeP = mb_convert_case(trim($employeesModel->EmployeeP), MB_CASE_TITLE, 'UTF-8');

            if ($employeesModel->validate()) {
                $review = Employees::model()->findBySQL("SELECT EmployeeID, STATUS FROM Employees WHERE EmployeeFN='" .
                    $employeesModel->EmployeeFN . "' AND EmployeeSN='" .
                    $employeesModel->EmployeeSN . "' AND EmployeeP='" .
                    $employeesModel->EmployeeP . "'");
                if ($review != NULL) {
                    $connection = Yii::app()->db;
                    $command = $connection->createCommand("UPDATE Employees SET STATUS='Работает' WHERE EmployeeID='" . $review->EmployeeID . "'");
                    $rowCount = $command->execute();

                    if ($rowCount == 1) {
                        Yii::app()->clientScript->registerScript(
                            'myHideEffect',
                            '$(".flash-success").animate({opacity: 1.0}, 3000).slideUp("medium");',
                            CClientScript::POS_READY
                        );
                        Yii::app()->user->setFlash('success', "Модельер " .
                            $employeesModel->EmployeeSN . " " .
                            $employeesModel->EmployeeFN . " " .
                            $employeesModel->EmployeeP . " успешно восстановлен!");
                    }
                } else if ($employeesModel->save()) {
                    Yii::app()->clientScript->registerScript(
                        'myHideEffect',
                        '$(".flash-success").animate({opacity: 1.0}, 3000).slideUp("medium");',
                        CClientScript::POS_READY
                    );
                    Yii::app()->user->setFlash('success', "Новый модельер " .
                        $employeesModel->EmployeeSN . " " .
                        $employeesModel->EmployeeFN . " " .
                        $employeesModel->EmployeeP . " успешно добавлен!");
                } else {
                    Yii::app()->clientScript->registerScript(
                        'myHideEffect',
                        '$(".flash-error").animate({opacity: 1.0}, 4000).slideUp("medium");',
                        CClientScript::POS_READY
                    );
                    Yii::app()->user->setFlash('error', "Ошибка при добавлении нового модельера!");
                }
            }
        }
        $employeesModel->unsetAttributes();
        $this->render('index', array(
            'employeesModel' => $employeesModel,
        ));
    }

    /**
     * ДЕЙСТВИЕ НОВЫЙ ЗАКАЗ
     */
    public function actionNew()
    {
        $model = new Orders;
        $customersModel = new Customers;
        $materialsModel = new Materials;
        $employeesModel = new Employees;
        $modelsModel = new Models;
        //$this->performAjaxValidation($model);

        if (isset($_POST['Orders'])) {
            $model->attributes = $_POST['Orders'];
            $customersModel->attributes = $_POST['Customers'];
            $materialsModel->attributes = $_POST['Materials'];
            $employeesModel->attributes = $_POST['Employees'];
            $modelsModel->attributes = $_POST['Models'];

            //фильтруем введенные значения
            //РАЗМЕРЫ
            if (strlen($model->Size) > 2) {
                //если длина введеной строки больше 2х цифр, значит для каждой ноги введен свой размер
                $array_size = explode(" ", $model->Size);
                $model->SizeLEFT = "s" . $array_size[0];
                $model->SizeRIGHT = "s" . $array_size[1];
            } else {
                //иначе размеры ног одинаковые
                $model->SizeLEFT = $model->SizeRIGHT = "s" . $model->Size;
            }

            //УРК
            if (strlen($model->Urk) > 3) {
                //если длина введеной строки больше 2х цифр, значит для каждой ноги введен свой размер
                $array_urk = explode(" ", $model->Urk);
                $model->UrkLEFT = "u" . $array_urk[0];
                $model->UrkRIGHT = "u" . $array_urk[1];
            } else {
                //иначе размеры ног одинаковые
                $model->UrkLEFT = $model->UrkRIGHT = "u" . $model->Urk;
            }

            //ВЫСОТА
            if (strlen($model->Height) > 2) {
                $array_height = explode(" ", $model->Height);
                $model->HeightLEFT = "h" . $array_height[0];
                $model->HeightRIGHT = "h" . $array_height[1];
            } else {
                $model->HeightLEFT = $model->HeightRIGHT = "h" . $model->Height;
            }

            //ОБЪЕМ ВЕРХА
            if (strlen($model->TopVolume) > 4) {
                $array_top_volume = explode(" ", $model->TopVolume);
                $model->TopVolumeLEFT = "t" . $array_top_volume[0] * 10;
                $model->TopVolumeRIGHT = "t" . $array_top_volume[1] * 10;
            } else {
                $model->TopVolumeLEFT = $model->TopVolumeRIGHT = "t" . $model->TopVolume * 10;
            }

            //ОБЪЕМ ЛОДЫЖКИ
            if (strlen($model->AnkleVolume) > 4) {
                $array_ankle_volume = explode(" ", $model->AnkleVolume);
                $model->AnkleVolumeLEFT = "a" . $array_ankle_volume[0] * 10;
                $model->AnkleVolumeRIGHT = "a" . $array_ankle_volume[1] * 10;
            } else {
                $model->AnkleVolumeLEFT = $model->AnkleVolumeRIGHT = "a" . $model->AnkleVolume * 10;
            }

            //ОБЪЕМ КВ
            if (strlen($model->KvVolume) > 4) {
                $array_kv_volume = explode(" ", $model->KvVolume);
                $model->KvVolumeLEFT = "k" . $array_kv_volume[0] * 10;
                $model->KvVolumeRIGHT = "k" . $array_kv_volume[1] * 10;
            } else {
                $model->KvVolumeLEFT = $model->KvVolumeRIGHT = "k" . $model->KvVolume * 10;
            }

            $model->MaterialID = $materialsModel->MaterialID;
            $model->EmployeeID = $employeesModel->EmployeeID;

            //пишем заказчика и модель в соответствующие таблицы, если ок, то заполняем таблицу заказов
            $transaction = $model->dbConnection->beginTransaction();
            try {
                // используем транзакцию, чтобы удостовериться в целостности данных
                //записываем заказчика
                $valid = $customersModel->validate();
                if ($valid) {
                    $customersModel->save();
                    $model->CustomerID = $customersModel->CustomerID;
                }

                //записываем модель
                // если чек-бокс отмечен, значит это новая модель, тут просто сохраняем
                // иначе мы должны вписать айдишник существующей модели и проапдейтить ее (возможно пользователь обновил ее данные)
                if ($modelsModel->basedID == null) {
                    if ($loadImage = CUploadedFile::getInstance($modelsModel, 'loadImage')) {
                        $modelsModel->loadImage = $loadImage;
                        $modelsModel->loadImage->saveAs(Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $modelsModel->loadImage->extensionName);
                        $modelsModel->ModelPicture = "" . Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $modelsModel->loadImage->extensionName;
                    }
                    $modelsModel->save();
                    $model->ModelID = $modelsModel->ModelID;
                } else {
                    // это запрос на изменение картинки существующей модели
                    $model->ModelID = $modelsModel->basedID;
                    $newDescroption = $modelsModel->ModelDescription;
                    $modelsModel = Models::model()->findByPk($model->ModelID);
                    if ($loadImage = CUploadedFile::getInstance($modelsModel, 'loadImage')) {
                        $modelsModel->loadImage = $loadImage;
                        $oldImage = $modelsModel->ModelPicture;
                        // удаляем старую картинку если она существует
                        if (file_exists($oldImage))
                            unlink($oldImage);
                        $modelsModel->loadImage->saveAs(Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $modelsModel->loadImage->extensionName);
                        $modelsModel->ModelPicture = Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $modelsModel->loadImage->extensionName;
                    }
                    $modelsModel->ModelDescription = $newDescroption;
                    $modelsModel->save();
                }


                $valid = $modelsModel->validate() && $valid;
                $valid = $model->validate() && $valid;
                // записываем заказ
                if ($model->save()) {
                    $transaction->commit();
                    Yii::app()->clientScript->registerScript(
                        'myHideEffect',
                        '$(".flash-success").animate({opacity: 1.0}, 5000).slideUp("slow");',
                        CClientScript::POS_READY
                    );
                    Yii::app()->user->setFlash('success', "Запись успешно добавлена!");

                    //очищаем поля формы
                    $model->unsetAttributes();
                    $materialsModel->unsetAttributes();
                    $employeesModel->unsetAttributes();
                    $modelsModel->unsetAttributes();
                    $customersModel->unsetAttributes();
                    $model->Size = null;
                    $model->Urk = null;
                    $model->Height = null;
                    $model->TopVolume = null;
                    $model->AnkleVolume = null;
                    $model->KvVolume = null;
                } else {
                    $transaction->rollback();
                    Yii::app()->clientScript->registerScript(
                        'myHideEffect',
                        '$(".flash-error").animate({opacity: 1.0}, 5000).slideUp("slow");',
                        CClientScript::POS_READY
                    );
                    Yii::app()->user->setFlash('error', "Ошибка при добавлении записи!");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
                Yii::app()->clientScript->registerScript(
                    'myHideEffect',
                    '$(".flash-error").animate({opacity: 1.0}, 5000).slideUp("slow");',
                    CClientScript::POS_READY
                );
                Yii::app()->user->setFlash('error', "Ошибка при добавлении записи!");
            }
        }

        $this->render('new', array('model' => $model,
            'customersModel' => $customersModel,
            'materialsModel' => $materialsModel,
            'employeesModel' => $employeesModel,
            'modelsModel' => $modelsModel,
        ));
    }

    /**
     * ДЕЙСТВИЕ ПОИСК
     */
    public function actionSearch()
    {
        $model = new Orders('search');
        $customersModel = new Customers('search');
        $materialsModel = new Materials('search');
        $employeesModel = new Employees('search');
        $modelsModel = new Models('search');

        $model->unsetAttributes();
        $customersModel->unsetAttributes();
        $materialsModel->unsetAttributes();
        $employeesModel->unsetAttributes();
        $modelsModel->unsetAttributes();

        if ( /*Yii::app()->request->isAjaxRequest &&*/
        isset($_GET['Orders'])
        ) {
            $model->attributes = $_GET['Orders'];
            $modelsModel->attributes = $_GET['Models'];
            $materialsModel->attributes = $_GET['Materials'];
            $employeesModel->attributes = $_GET['Employees'];
            $customersModel->attributes = $_GET['Customers'];

            // генерируем условия поиска
            $where = "";
            // сохраням javascript код, который затем выведем
            $js = "";

            if (!empty($model->OrderID)) {
                $ids = trim(strip_tags($model->OrderID));
                $this->getWhere($ids, 'OrderID', '', '', $where);
                $js .= $this->jquery_highlight_create($ids, 1);
            }

            if (!empty($modelsModel->ModelName)) {
                $models = trim(strip_tags($modelsModel->ModelName));
                $this->getWhere($models, 'ModelName', '', '', $where);
                $js .= $this->jquery_highlight_create($models, 2);
            }

            if (!empty($model->Size)) {
                $sizes = trim(strip_tags($model->Size));
                $this->getWhere($sizes, 'SizeLEFT', 'SizeRIGHT', 's', $where);
                $js .= $this->jquery_highlight_create($sizes, 3);
            }

            if (!empty($model->Urk)) {
                $urks = trim(strip_tags($model->Urk));
                $this->getWhere($urks, 'UrkLEFT', 'UrkRIGHT', 'u', $where);
                $js .= $this->jquery_highlight_create($urks, 4);
            }

            if (!empty($model->Height)) {
                $heights = trim(strip_tags($model->Height));
                $this->getWhere($heights, 'HeightLEFT', 'HeightRIGHT', 'h', $where);
                $js .= $this->jquery_highlight_create($heights, 6);
            }

            if (!empty($model->TopVolume)) {
                $topvolumes = trim(strip_tags($model->TopVolume));
                $this->getWhere($topvolumes, 'TopVolumeLEFT', 'TopVolumeRIGHT', 't', $where);
                $js .= $this->jquery_highlight_create($topvolumes, 7);
            }

            if (!empty($model->AnkleVolume)) {
                $anklevolume = trim(strip_tags($model->AnkleVolume));
                $this->getWhere($anklevolume, 'AnkleVolumeLEFT', 'AnkleVolumeRIGHT', 'a', $where);
                $js .= $this->jquery_highlight_create($anklevolume, 8);
            }

            if (!empty($model->KvVolume)) {
                $kvvolume = trim(strip_tags($model->KvVolume));
                $this->getWhere($kvvolume, 'KvVolumeLEFT', 'KvVolumeRIGHT', 'k', $where);
                $js .= $this->jquery_highlight_create($kvvolume, 9);
            }

            if (!empty($materialsModel->MaterialID)) {
                $searchMeaterials = "";
                foreach ($materialsModel->MaterialID as $meterialId) {
                    $searchMeaterials .= "'" . $meterialId . "',";
                    $js .= " $('td:nth-child(5)').highlight('" . Materials::getMaterialShortcutList($meterialId) . "'); ";
                }
                if (empty($where)) {
                    $where .= " MaterialID IN (" . substr($searchMeaterials, 0, strlen($searchMeaterials) - 1) . ") ";
                } else {
                    $where .= " AND MaterialID IN (" . substr($searchMeaterials, 0, strlen($searchMeaterials) - 1) . ") ";
                }
            }
            // end of materials

            if (!empty($employeesModel->EmployeeID)) {
                $searchEmployees = "";
                foreach ($employeesModel->EmployeeID as $employeeId) {
                    $searchEmployees .= "'" . $employeeId . "',";
                    $js .= " $('td:nth-child(11)').highlight('" . Employees::getEmployeeShortcutList($employeeId) . "'); ";
                }
                if (empty($where)) {
                    $where .= " EmployeeID IN(" . substr($searchEmployees, 0, strlen($searchEmployees) - 1) . ") ";
                } else {
                    $where .= " AND EmployeeID IN (" . substr($searchEmployees, 0, strlen($searchEmployees) - 1) . ") ";
                }
            }
            // end of employees

            if (!empty($customersModel->CustomerSN)) {
                if (empty($where)) {
                    $where .= " CustomerSN='" . trim(strip_tags($customersModel->CustomerSN)) . "' ";
                } else {
                    $where .= " OR CustomerSN='" . trim(strip_tags($customersModel->CustomerSN)) . "' ";
                }
                $js .= " $('td:nth-child(10)').highlight('" . $customersModel->CustomerSN . "'); ";
            }

            if (!empty($customersModel->CustomerFN)) {
                if (empty($where)) {
                    $where .= " CustomerFN='" . trim(strip_tags($customersModel->CustomerFN)) . "' ";
                } else {
                    $where .= " OR CustomerFN='" . trim(strip_tags($customersModel->CustomerFN)) . "' ";
                }
                $js .= " $('td:nth-child(10)').highlight('" . $customersModel->CustomerFN . "'); ";
            }

            if (!empty($customersModel->CustomerP)) {
                if (empty($where)) {
                    $where .= " CustomerP='" . trim(strip_tags($customersModel->CustomerP)) . "' ";
                } else {
                    $where .= " OR CustomerP='" . trim(strip_tags($customersModel->CustomerP)) . "' ";
                }
                $js .= " $('td:nth-child(10)').highlight('" . $customersModel->CustomerP . "'); ";
            }

            if (isset($_GET['Orders']['Comment']) && !empty($_GET['Orders']['Comment'])) {
                if (empty($where))
                    $where .= " Comment LIKE '%" . $_GET['Orders']['Comment'] . "%' ";
                else
                    $where .= " OR Comment LIKE '%" . $_GET['Orders']['Comment'] . "%' ";
                $js .= " $('td:nth-child(13)').highlight('" . $_GET['Orders']['Comment'] . "'); ";
            }

            Yii::app()->clientScript->registerPackage('highlight');
            Yii::app()->clientScript->registerScript('highlightQuery', $js, CClientScript::POS_READY);

            $criteria = new CDbCriteria;
            $criteria->condition = $where;

            $dataProvider = new CActiveDataProvider(Orders::model()->with('model', 'customer'), array(
                'criteria' => $criteria,
                //	'enablePagination'=>false,
                'pagination' => array(
                    'pageSize' => 20,
                ),
                'sort' => array(
                    //атрибуты по которым происходит сортировка
                    'attributes' => array(
                        'OrderID' => array(
                            'asc' => 'OrderID ASC',
                            'desc' => 'OrderID DESC',
                            //по умолчанию, сортируем поле OrderID по убыванию (desc)
                            'default' => 'desc',
                        ),
                        'ModelName' => array(
                            'asc' => 'ModelName ASC',
                            'desc' => 'ModelName DESC',
                            'default' => 'desc',
                        ),
                        'MaterialID' => array(
                            'asc' => 'MaterialID ASC',
                            'desc' => 'MaterialID DESC',
                            'default' => 'desc',
                        ),
                        'EmployeeID' => array(
                            'asc' => 'EmployeeID ASC',
                            'desc' => 'EmployeeID DESC',
                            'default' => 'desc',
                        ),
                        'Date' => array(
                            'asc' => 'Date',
                            'desc' => 'Date DESC',
                            'default' => 'desc',
                        ),
                    ),
                    'defaultOrder' => array(
                        'Date' => CSort::SORT_DESC,
                    )
                ),
            ));

            $this->render('search', array('dataProvider' => $dataProvider,
                'model' => $model,
                'customersModel' => $customersModel,
                'materialsModel' => $materialsModel,
                'employeesModel' => $employeesModel,
                'modelsModel' => $modelsModel,
            ));
            //$this->renderPartial('tableOrders' , array('dataProvider'=>$dataProvider, 'js'=>$js), false, true);
            // Завершаем приложение
            Yii::app()->end();
        }

        $this->render('search', array('model' => $model,
            'customersModel' => $customersModel,
            'materialsModel' => $materialsModel,
            'employeesModel' => $employeesModel,
            'modelsModel' => $modelsModel,
        ));
    }

    /**
     * ДЕЙСТВИЕ ВСЕ ЗАКАЗЫ
     */
    public function actionView()
    {
        $criteria = new CDbCriteria;

        // Быстрый поиск прямо на странице всех заказов
        if (!empty($_GET['quickSearchValue'])) {
            $quickSearchQuery = explode(" ", $_GET['quickSearchValue']);
            $quickSearchQuery = trim($quickSearchQuery[0]);
            $queryForVolumes = $quickSearchQuery * 10;
            $quickSearchQuery = iconv(mb_detect_encoding($quickSearchQuery, mb_detect_order(), true), "utf-8", $quickSearchQuery);
            $criteria->together = true;
            $searchDate = '#';

            if (strtotime($quickSearchQuery))
                $searchDate = date($quickSearchQuery);

            $query = "`OrderID` ='" . $quickSearchQuery . "' ";
            $query .= " OR ModelName ='" . $quickSearchQuery . "' ";
            $query .= " OR MaterialValue = '" . $quickSearchQuery . "' ";
            $query .= " OR SizeLEFT='s" . $quickSearchQuery . "' ";
            $query .= " OR SizeRIGHT='s" . $quickSearchQuery . "' ";
            $query .= " OR UrkLEFT='u" . $quickSearchQuery . "' ";
            $query .= " OR UrkRIGHT='u" . $quickSearchQuery . "' ";
            $query .= " OR HeightLEFT='h" . $quickSearchQuery . "' ";
            $query .= " OR HeightRIGHT='h" . $quickSearchQuery . "' ";
            $query .= " OR TopVolumeLEFT='t" . $queryForVolumes . "' ";
            $query .= " OR TopVolumeRIGHT='t" . $queryForVolumes . "' ";
            $query .= " OR AnkleVolumeLEFT='a" . $queryForVolumes . "' ";
            $query .= " OR AnkleVolumeRIGHT='a" . $queryForVolumes . "' ";
            $query .= " OR KvVolumeLEFT='k" . $queryForVolumes . "' ";
            $query .= " OR KvVolumeRIGHT='k" . $queryForVolumes . "' ";
            $query .= " OR EmployeeSN='" . $quickSearchQuery . "' ";
            $query .= " OR EmployeeFN='" . $quickSearchQuery . "' ";
            $query .= " OR EmployeeP='" . $quickSearchQuery . "' ";
            $query .= " OR CustomerSN='" . $quickSearchQuery . "' ";
            $query .= " OR CustomerFN='" . $quickSearchQuery . "' ";
            $query .= " OR CustomerP='" . $quickSearchQuery . "' ";
            $query .= " OR Date LIKE '%" . $searchDate . "%' ";
            $query .= " OR Comment ='" . $quickSearchQuery . "' ";
            $criteria->condition = $query;
        }

        $dataProvider = new CActiveDataProvider(Orders::model()->with(
                'material',
                'model',
                'sizeLEFT',
                'sizeRIGHT',
                'topVolumeLEFT',
                'topVolumeRIGHT',
                'ankleVolumeLEFT',
                'ankleVolumeRIGHT',
                'kvVolumeLEFT',
                'kvVolumeRIGHT',
                'customer',
                'employee',
                'urkLEFT',
                'urkRIGHT',
                'heightLEFT',
                'heightRIGHT'
            ),
            array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 20,
                ),
                'sort' => array(
                    //атрибуты по которым происходит сортировка
                    'attributes' => array(
                        'OrderID' => array(
                            'asc' => 'OrderID ASC',
                            'desc' => 'OrderID DESC',
                            //по умолчанию, сортируем поле OrderID по убыванию (desc)
                            'default' => 'desc',
                        ),
                        'ModelName' => array(
                            'asc' => 'ModelName ASC',
                            'desc' => 'ModelName DESC',
                            'default' => 'desc',
                        ),
                        'MaterialValue' => array(
                            'asc' => 'MaterialValue ASC',
                            'desc' => 'MaterialValue DESC',
                            'default' => 'desc',
                        ),
                        'EmployeeSN' => array(
                            'asc' => 'EmployeeSN ASC',
                            'desc' => 'EmployeeSN DESC',
                            'default' => 'desc',
                        ),
                        'Date' => array(
                            'asc' => 'Date',
                            'desc' => 'Date DESC',
                            'default' => 'desc',
                        ),
                    ),
                    'defaultOrder' => array(
                        'Date' => CSort::SORT_DESC,
                    )
                ),
            ));

        $this->render('view', array('dataProvider' => $dataProvider));
    }

    /**
     * ДЕЙСТВИЕ РЕДАКТИРОВАНИЕ
     */
    public function actionUpdate($id)
    {
        $model = Orders::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, 'Указанная запись не найдена');
        }
        $model = Orders::model()->with(
            'material',
            'model',
            'sizeLEFT',
            'sizeRIGHT',
            'topVolumeLEFT',
            'topVolumeRIGHT',
            'ankleVolumeLEFT',
            'ankleVolumeRIGHT',
            'kvVolumeLEFT',
            'kvVolumeRIGHT',
            'customer',
            'employee',
            'urkLEFT',
            'urkRIGHT',
            'heightLEFT',
            'heightRIGHT'
        )->findByPk($id);
        //	$model->scenario = 'update';
        $customersModel = Customers::model()->findByPk($model->CustomerID);
        $materialsModel = Materials::model()->findByPk($model->MaterialID);
        $employeesModel = Employees::model()->findByPk($model->EmployeeID);
        $modelsModel = Models::model()->findByPk($model->ModelID);

        if (isset($_POST['Orders'])) {
            $model->attributes = $_POST['Orders'];
            $materialsModel->attributes = $_POST['Materials'];
            $employeesModel->attributes = $_POST['Employees'];
            $modelsModel->attributes = $_POST['Models'];
            $customersModel->attributes = $_POST['Customers'];

            $model->OrderID = $model->OrderIDUpdate;

            // РАЗМЕРЫ
            $model->SizeLEFT = "s" . $model->SizeLEFTUpdate;
            $model->SizeRIGHT = "s" . $model->SizeRIGHTUpdate;

            // УРК
            $model->UrkLEFT = "u" . $model->UrkLEFTUpdate;
            $model->UrkRIGHT = "u" . $model->UrkRIGHTUpdate;

            // ВЫСОТА
            $model->HeightLEFT = "h" . $model->HeightLEFTUpdate;
            $model->HeightRIGHT = "h" . $model->HeightRIGHTUpdate;

            // Объем верха
            $model->TopVolumeLEFT = "t" . $model->TopVolumeLEFTUpdate * 10;
            $model->TopVolumeRIGHT = "t" . $model->TopVolumeRIGHTUpdate * 10;

            // Объем ложыхки
            $model->AnkleVolumeLEFT = "a" . $model->AnkleVolumeLEFTUpdate * 10;
            $model->AnkleVolumeRIGHT = "a" . $model->AnkleVolumeRIGHTUpdate * 10;

            // Объем КВ
            $model->KvVolumeLEFT = "k" . $model->KvVolumeLEFTUpdate * 10;
            $model->KvVolumeRIGHT = "k" . $model->KvVolumeRIGHTUpdate * 10;

            $model->MaterialID = $materialsModel->MaterialID;
            $model->EmployeeID = $employeesModel->EmployeeID;

            $customersModel->CustomerSN = $customersModel->CustomerSNUpdate;
            $customersModel->CustomerFN = $customersModel->CustomerFNUpdate;
            $customersModel->CustomerP = $customersModel->CustomerPUpdate;

            $transaction = $model->dbConnection->beginTransaction();
            try {
                // используем транзакцию, чтобы удостовериться в целостности данных
                //записываем заказчика
                $valid = $customersModel->validate();
                if ($valid) {
                    $customersModel->save();
                }

                //записываем модель, если чек-бокс отмечен, значит это новая модель, тут просто сохраняем
                // иначе мы должны вписать айдишник существующей модели и проапдейтить ее (возможно пользователь обновил ее данные)
                if ($modelsModel->basedID == null) {
                    $newModel = new Models;
                    $newModel->attributes = $_POST['Models'];
                    if ($loadImage = CUploadedFile::getInstance($newModel, 'loadImage')) {
                        $newModel->loadImage = $loadImage;
                        $newModel->loadImage->saveAs(Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $newModel->loadImage->extensionName);
                        $newModel->ModelPicture = "" . Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $newModel->loadImage->extensionName;
                    }
                    $newModel->save();
                    $model->ModelID = $newModel->ModelID;
                } else {
                    // это запрос на изменение картинки существующей модели
                    $model->ModelID = $modelsModel->basedID;
                    $newDescroption = $modelsModel->ModelDescription;
                    $modelsModel = Models::model()->findByPk($model->ModelID);
                    if ($loadImage = CUploadedFile::getInstance($modelsModel, 'loadImage')) {
                        $modelsModel->loadImage = $loadImage;
                        $oldImage = $modelsModel->ModelPicture;
                        // удаляем старую картинку если она существует
                        if (file_exists($oldImage))
                            unlink($oldImage);
                        $modelsModel->loadImage->saveAs(Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $modelsModel->loadImage->extensionName);
                        $modelsModel->ModelPicture = Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $modelsModel->loadImage->extensionName;
                    }
                    $modelsModel->ModelDescription = $newDescroption;
                    $modelsModel->save();
                }


                $valid = $modelsModel->validate() && $valid;
                $valid = $model->validate() && $valid;
                // записываем заказ
                if ($model->save()) {
                    $transaction->commit();
                    Yii::app()->clientScript->registerScript(
                        'myHideEffect',
                        '$(".flash-success").animate({opacity: 1.0}, 5000).slideUp("slow");',
                        CClientScript::POS_READY
                    );
                    Yii::app()->user->setFlash('success', "Запись успешно изменена!");

                    //очищаем поля формы
                    $model->unsetAttributes();
                    $materialsModel->unsetAttributes();
                    $employeesModel->unsetAttributes();
                    $modelsModel->unsetAttributes();
                    $customersModel->unsetAttributes();

                    $this->redirect(array('view'));
                } else {
                    $transaction->rollback();
                    Yii::app()->clientScript->registerScript(
                        'myHideEffect',
                        '$(".flash-error").animate({opacity: 1.0}, 5000).slideUp("slow");',
                        CClientScript::POS_READY
                    );
                    Yii::app()->user->setFlash('error', "Ошибка при редактировании записи!");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
                Yii::app()->clientScript->registerScript(
                    'myHideEffect',
                    '$(".flash-error").animate({opacity: 1.0}, 5000).slideUp("slow");',
                    CClientScript::POS_READY
                );
                Yii::app()->user->setFlash('error', "Ошибка при редактировании записи!");
            }
        }

        $this->render('update', array(
            'model' => $model,
            'customersModel' => $customersModel,
            'materialsModel' => $materialsModel,
            'employeesModel' => $employeesModel,
            'modelsModel' => $modelsModel,
        ));
    }

    /**
     * ДЕЙСТВИЕ УДАЛЕНИЕ ЗАКАЗА
     */
    public function actionDelete($id)
    {
        if (Yii::app()->user->isGuest) {
            throw new CException('У Вас недостаточно прав для данной операции');
        }
        $this->loadModel($id)->delete();
        $this->redirect(array('view'));
    }

    /**
     * ДЕЙСТВИЯ АДМИНИСТРАТИВНОЙ ЧАСТИ
     */
    public function actionAdmin()
    {
        $employeesModel = new Employees('delete');
        $materialsModel = new Materials('add');

        // УДАЛИТЬ МОДЕЛЬЕРА
        if (isset($_POST['Employees'])) {
            $id = (int)trim($_POST['Employees']['EmployeeID']);

            $connection = Yii::app()->db;
            $command = $connection->createCommand("UPDATE Employees SET STATUS='Уволен' WHERE EmployeeID='" . $id . "'");
            $rowCount = $command->execute();
            if ($rowCount == 1) {
                Yii::app()->clientScript->registerScript(
                    'myHideEffect',
                    '$(".flash-success").animate({opacity: 1.0}, 2000).slideUp("medium");',
                    CClientScript::POS_READY
                );
                Yii::app()->user->setFlash('success', "Модельер успешно удален!");
            }
        }

        // ОПТИМИЗИРОВАТЬ БД
        if (isset($_POST['optimizeDbBtn'])) {
            $connection = Yii::app()->db;
            $command = $connection->createCommand('OPTIMIZE TABLE Orders, Employees, Customers, Materials, Sizes, Urk, Height, TopVolume, AnkleVolume, KvVolume, Models');
            $result = $command->execute();
            Yii::app()->clientScript->registerScript(
                'myHideEffect',
                '$(".flash-success").animate({opacity: 1.0}, 2000).slideUp("medium");',
                CClientScript::POS_READY
            );
            Yii::app()->user->setFlash('success', "Оптимизация успешно завершена!");
        }

        // БЕКАП БД
        if (isset($_POST['backupDbBtn'])) {
            $now = date("_Y-n-d__H-i-s");
            $filename = "BACKUP_DB_SHOES_" . $now . ".sql";
            $command = "mysqldump --flush-logs --lock-tables --databases -u" . Yii::app()->db->username . " -p" . Yii::app()->db->password . " -hlocalhost SHOES > $filename";
            $result = system($command);
            if (!$result) {
                ob_clean();
                header("Content-Type: text/plain;");
                header("Content-Disposition: attachment; filename='$filename'");
                echo file_get_contents($filename);
                unlink($filename);
                exit();
            }
        }

        // ВОССТАНОВИТЬ БД
        if (isset($_POST['recoveryDbBtn'])) {
            if (($_FILES['recoveryDb']['type'] == 'text/x-sql' OR $_FILES['recoveryDb']['type'] == 'application/octet-stream') AND $_FILES['recoveryDb']['error'] == 0) {
                $tmp = $_FILES['recoveryDb']['tmp_name'];
                $name = $_FILES['recoveryDb']['name'];
                move_uploaded_file($tmp, $name);

                $command = "mysql -u" . Yii::app()->db->username . " -p" . Yii::app()->db->password . " SHOES < $name";
                $result = system($command);
                unlink("$name");
                if (!$result) {
                    Yii::app()->clientScript->registerScript(
                        'myHideEffect',
                        '$(".flash-success").animate({opacity: 1.0}, 2000).slideUp("medium");',
                        CClientScript::POS_READY
                    );
                    Yii::app()->user->setFlash('success', "База Данных успешно восстановлена из резервной копии!");
                } else {
                    Yii::app()->clientScript->registerScript(
                        'myHideEffect',
                        '$(".flash-error").animate({opacity: 1.0}, 5000).slideUp("slow");',
                        CClientScript::POS_READY
                    );
                    Yii::app()->user->setFlash('error', "Ошибка восстановления базы данных.");
                }
            } else {
                Yii::app()->clientScript->registerScript(
                    'myHideEffect',
                    '$(".flash-error").animate({opacity: 1.0}, 5000).slideUp("medium");',
                    CClientScript::POS_READY
                );
                Yii::app()->user->setFlash('error', "Ошибка загрузки файла. Файл неверного расширения или содержит ошибки.");
            }
        }

        // ОТДАТЬ EXCEL
        if (isset($_POST['saveAsExcel'])) {
            $start = $_POST['startDate'];
            $end = $_POST['endDate'];

            // проверка, что выбранная конечная дата больше начальной
            if ((strtotime($end) - strtotime($start)) < 0) {
                Yii::app()->clientScript->registerScript(
                    'myHideEffect',
                    '$(".flash-error").animate({opacity: 1.0}, 2000).slideUp("medium");',
                    CClientScript::POS_READY
                );
                Yii::app()->user->setFlash('error', "Ошибка! Начальная дата больше конечной!");
            } else {
                $starts = $start; // формат даты для вывода в шапке таблицы
                $ends = $end; // формат даты для вывода в шапке таблицы

                $start .= ' 00:00:00';
                $end .= ' 23:59:59';
                $start = date("Y-m-d H-i-s", strtotime($start));
                $end = date("Y-m-d H-i-s", strtotime($end));

                Yii::import('ext.phpexcel.XPHPExcel');
                $xls = XPHPExcel::createPHPExcel();

                // Устанавливаем индекс активного листа
                // необходима таблица, шириной 19 ячеек, 6 их них объединены
                $xls->setActiveSheetIndex(0);
                // Получаем активный лист и подписываем
                $sheet = $xls->getActiveSheet();
                $sheet->setTitle('Заказы за период');

                //Ориентация страницы и  размер листа
                $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

                //Поля документа
                $sheet->getPageMargins()->setTop(1);
                $sheet->getPageMargins()->setRight(0.75);
                $sheet->getPageMargins()->setLeft(0.75);
                $sheet->getPageMargins()->setBottom(1);

                $sheet->setCellValue("A1", 'Таблица заказов Санкт-Петербургской фабрики ортопедической обуви за период с ' . $starts . ' по ' . $ends . '.');
                $sheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor();
                $sheet->mergeCells('A1:S1');

                // Выравнивание текста
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $sheet->getRowDimension('1')->setRowHeight(34);
                // подготавливаем шапку таблицы
                $sheet->setCellValue('A2', 'Номер заказа')->mergeCells('A2:A3')
                    ->setCellValue('B2', 'Модель')->mergeCells('B2:B3')
                    ->setCellValue('C2', 'Размер')->mergeCells('C2:D2')
                    ->setCellValue('E2', 'Длина УРК')->mergeCells('E2:F2')
                    ->setCellValue('G2', 'Материал')->mergeCells('G2:G3')
                    ->setCellValue('H2', 'Высота')->mergeCells('H2:I2')
                    ->setCellValue('J2', 'Объем верха')->mergeCells('J2:K2')
                    ->setCellValue('L2', 'Объем лодыжки')->mergeCells('L2:M2')
                    ->setCellValue('N2', 'Объем КВ')->mergeCells('N2:O2')
                    ->setCellValue('P2', 'Заказчик')->mergeCells('P2:P3')
                    ->setCellValue('Q2', 'Модельер')->mergeCells('Q2:Q3')
                    ->setCellValue('R2', 'Дата заказа')->mergeCells('R2:R3')
                    ->setCellValue('S2', 'Комментарий')->mergeCells('S2:S3')
                    ->setCellValue('C3', 'Левый')->setCellValue('D3', 'Правый')
                    ->setCellValue('E3', 'Левый')->setCellValue('F3', 'Правый')
                    ->setCellValue('H3', 'Левый')->setCellValue('I3', 'Правый')
                    ->setCellValue('J3', 'Левый')->setCellValue('K3', 'Правый')
                    ->setCellValue('L3', 'Левый')->setCellValue('M3', 'Правый')
                    ->setCellValue('N3', 'Левый')->setCellValue('O3', 'Правый');


                // Стили для шапки таблицы
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setItalic(true);

                // Выравниваем по центру и рисуем рамки
                $styleTop = array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('rgb' => '000000')
                        ),
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('rgb' => '000000')
                        ),
                        'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('rgb' => '000000')
                        ),
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('rgb' => '000000')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    ),
                );

                $sheet->getStyle('A1:S1')->applyFromArray($styleTop);
                $sheet->getStyle('A2:A3')->applyFromArray($styleTop);
                $sheet->getStyle('B2')->applyFromArray($styleTop);
                $sheet->getStyle('G2')->applyFromArray($styleTop);
                $sheet->getStyle('P2:P3')->applyFromArray($styleTop);
                $sheet->getStyle('Q2:Q3')->applyFromArray($styleTop);
                $sheet->getStyle('R2:R3')->applyFromArray($styleTop);
                $sheet->getStyle('S2:S3')->applyFromArray($styleTop);
                $sheet->getStyle('C2')->applyFromArray($styleTop);
                $sheet->getStyle('E2')->applyFromArray($styleTop);
                $sheet->getStyle('H2')->applyFromArray($styleTop);
                $sheet->getStyle('J2')->applyFromArray($styleTop);
                $sheet->getStyle('L2')->applyFromArray($styleTop);
                $sheet->getStyle('N2')->applyFromArray($styleTop);

                $styleMergeTopLeft = array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('rgb' => '000000')
                        ),
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('rgb' => '000000')
                        ),
                        'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('rgb' => '000000')
                        ),
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    ),
                );

                $styleMergeTopRight = array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('rgb' => '000000')
                        ),
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('rgb' => '000000')
                        ),
                        'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        ),
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array('rgb' => '000000')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    ),
                );

                $sheet->getStyle('C3')->applyFromArray($styleMergeTopLeft);
                $sheet->getStyle('E3')->applyFromArray($styleMergeTopLeft);
                $sheet->getStyle('H3')->applyFromArray($styleMergeTopLeft);
                $sheet->getStyle('J3')->applyFromArray($styleMergeTopLeft);
                $sheet->getStyle('L3')->applyFromArray($styleMergeTopLeft);
                $sheet->getStyle('N3')->applyFromArray($styleMergeTopLeft);
                $sheet->getStyle('D3')->applyFromArray($styleMergeTopRight);
                $sheet->getStyle('F3')->applyFromArray($styleMergeTopRight);
                $sheet->getStyle('I3')->applyFromArray($styleMergeTopRight);
                $sheet->getStyle('K3')->applyFromArray($styleMergeTopRight);
                $sheet->getStyle('M3')->applyFromArray($styleMergeTopRight);
                $sheet->getStyle('O3')->applyFromArray($styleMergeTopRight);

                // делаем у столбцов фиксированную ширину;
                $sheet->getColumnDimension('A')->setWidth(14);
                $sheet->getColumnDimension('B')->setWidth(14);
                $sheet->getColumnDimension('C')->setWidth(8);
                $sheet->getColumnDimension('D')->setWidth(8);
                $sheet->getColumnDimension('E')->setWidth(8);
                $sheet->getColumnDimension('F')->setWidth(8);
                $sheet->getColumnDimension('G')->setWidth(12);
                $sheet->getColumnDimension('H')->setWidth(8);
                $sheet->getColumnDimension('I')->setWidth(8);
                $sheet->getColumnDimension('J')->setWidth(8);
                $sheet->getColumnDimension('K')->setWidth(8);
                $sheet->getColumnDimension('L')->setWidth(8);
                $sheet->getColumnDimension('M')->setWidth(8);
                $sheet->getColumnDimension('N')->setWidth(8);
                $sheet->getColumnDimension('O')->setWidth(8);
                $sheet->getColumnDimension('P')->setWidth(18);
                $sheet->getColumnDimension('Q')->setWidth(18);
                $sheet->getColumnDimension('R')->setWidth(14);
                $sheet->getColumnDimension('S')->setWidth(20);

                // массивы стилей для столбцов:
                $arrayABGPQRS = array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wrap' => true,
                    ),
                );

                $arrayCDEFHIJKLMNO = array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wrap' => true,
                    ),
                );

                // левые смежные ячейки
                $arrayCEHJLN = array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wrap' => true,
                    ),
                );

                // правые смежные ячейки
                $arrayDFIKMO = array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        ),
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => array(
                                'rgb' => '333333'
                            )
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wrap' => true,
                    ),
                );
                // запрос в базу
                $criteria = new CDbCriteria;
                $criteria->addBetweenCondition('Date', $start, $end, 'AND');
                $criteria->order = 'Date DESC';
                $data = Orders::model()->with(
                    'material',
                    'model',
                    'sizeLEFT',
                    'sizeRIGHT',
                    'topVolumeLEFT',
                    'topVolumeRIGHT',
                    'ankleVolumeLEFT',
                    'ankleVolumeRIGHT',
                    'kvVolumeLEFT',
                    'kvVolumeRIGHT',
                    'customer',
                    'employee',
                    'urkLEFT',
                    'urkRIGHT',
                    'heightLEFT',
                    'heightRIGHT'
                )->findAll($criteria);

                //  заполняем документ заказами:
                foreach ($data as $value) {
                    static $i = 4;

                    $sheet->setCellValue("A" . $i, $value->OrderID)
                        ->getStyle("A" . $i)->applyFromArray($arrayABGPQRS);

                    $sheet->setCellValue("B" . $i, $value->model->ModelName)
                        ->getStyle("B" . $i)->applyFromArray($arrayABGPQRS);

                    $sheet->setCellValue("C" . $i, $value->sizeLEFT->SizeValue)
                        ->getStyle("C" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("D" . $i, $value->sizeRIGHT->SizeValue)
                        ->getStyle("D" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("E" . $i, $value->urkLEFT->UrkValue)
                        ->getStyle("E" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("F" . $i, $value->urkRIGHT->UrkValue)
                        ->getStyle("F" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("G" . $i, $value->material->MaterialValue)
                        ->getStyle("G" . $i)->applyFromArray($arrayABGPQRS);

                    $sheet->setCellValue("H" . $i, $value->heightLEFT->HeightValue)
                        ->getStyle("H" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("I" . $i, $value->heightRIGHT->HeightValue)
                        ->getStyle("I" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("J" . $i, $value->topVolumeLEFT->TopVolumeValue)
                        ->getStyle("J" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("K" . $i, $value->topVolumeRIGHT->TopVolumeValue)
                        ->getStyle("K" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("L" . $i, $value->ankleVolumeLEFT->AnkleVolumeValue)
                        ->getStyle("L" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("M" . $i, $value->ankleVolumeRIGHT->AnkleVolumeValue)
                        ->getStyle("M" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("N" . $i, $value->kvVolumeLEFT->KvVolumeValue)
                        ->getStyle("N" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("O" . $i, $value->kvVolumeRIGHT->KvVolumeValue)
                        ->getStyle("O" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("P" . $i, $value->customer->CustomerSN . " " .
                        $value->customer->CustomerFN . " " .
                        $value->customer->CustomerP)
                        ->getStyle("P" . $i)->applyFromArray($arrayABGPQRS);

                    $sheet->setCellValue("Q" . $i, $value->employee->EmployeeSN . " " .
                        $value->employee->EmployeeFN . " " .
                        $value->employee->EmployeeP)
                        ->getStyle("Q" . $i)->applyFromArray($arrayABGPQRS);

                    $sheet->setCellValue("R" . $i, $value->Date)->getStyle("R" . $i)->applyFromArray($arrayABGPQRS);
                    $sheet->setCellValue("S" . $i, $value->Comment)->getStyle("S" . $i)->applyFromArray($arrayABGPQRS);

                    $sheet->getRowDimension($i)->setRowHeight(28);
                    ++$i;
                }

                // Выводим HTTP-заголовки
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="orders.xls"');
                header('Cache-Control: no-cache, must-revalidate');
                header('Pragma: no-cache');
                // Выводим содержимое excel-файла
                $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel5');
                $objWriter->save('php://output');
            }
        }

        // НОВЫЙ МАТЕРИАЛ
        if (isset($_POST['newMaterialBtn'])) {
            $materialsModel->attributes = $_POST['Materials'];
            $materialsModel->MaterialValue = mb_convert_case(trim($materialsModel->MaterialValue), MB_CASE_TITLE, 'UTF-8');

            if ($materialsModel->validate()) {
                if ($materialsModel->save()) {
                    Yii::app()->clientScript->registerScript(
                        'myHideEffect',
                        '$(".flash-success").animate({opacity: 1.0}, 3000).slideUp("medium");',
                        CClientScript::POS_READY
                    );
                    Yii::app()->user->setFlash('success', "Новый материал " . $materialsModel->MaterialValue . " успешно добавлен!");
                } else {
                    Yii::app()->clientScript->registerScript(
                        'myHideEffect',
                        '$(".flash-error").animate({opacity: 1.0}, 4000).slideUp("medium");',
                        CClientScript::POS_READY
                    );
                    Yii::app()->user->setFlash('error', "Ошибка при добавлении нового материала!");
                }
                $materialsModel->unsetAttributes();
            }
        }

        $this->render('admin', array(
            'employeesModel' => $employeesModel,
            'materialsModel' => $materialsModel,
        ));
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
        $model = new ContactForm;
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
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function loadModel($id)
    {
        $model = Orders::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая страница не существует.');
        return $model;
    }

    public function actionGetModelNames($term)
    {
        echo Models::model()->getModelNames($term);
    }

    public function actionGetModelInfo()
    {
        echo Models::model()->getModels($_POST['modelName']);
    }

    public function actionGetModelInfoById()
    {
        echo Models::model()->getModelById($_POST['id']);
    }

    /*
	 * ПОДСВЕТКА СЛОВ ПОИСКА
     */
    function jquery_highlight_create($from_post, $num_child)
    {
        $array_field = explode(" ", $from_post);
        $params = "";
        foreach ($array_field as $num) {
            if (strpbrk($num, "-")) {
                $num_interval = explode("-", $num);
                for ($i = $num_interval[0]; $i <= $num_interval[1]; ++$i)
                    $params .= " $('td:nth-child($num_child)').highlight('" . $i . "'); ";
            } else {
                $params .= " $('td:nth-child($num_child)').highlight('" . $num . "'); ";
            }
        }
        return $params;
    }

    /*
     * СОЗДАНИЕ УСЛОВИЯ ПОИСКА WHERE
     */
    public function getWhere($inputData, $left, $right, $prefix, &$where)
    {
        if (empty($where)) {
            // WHERE ПУСТОЙ
            // разбиваем по пробелу полученные данные
            $array_data = explode(" ", $inputData);
            // необходимо обойти каждый элемент массива в цикле и
            // проверяем на наличие диапазона
            $iteration = 0;
            foreach ($array_data as $data_field) {
                $iteration++;
                if ($iteration == count($array_data)) {
                    // значит элемент массива последний
                    // если есть дефис, значит это интервал
                    if (strpbrk($data_field, "-")) {
                        // разбираем интервал
                        $interval = explode("-", $data_field);

                        if ($prefix == 't' or $prefix == 'a' or $prefix == 'k') {
                            $interval[0] *= 10;
                            $interval[1] *= 10;
                        }
                        if ($right == '')
                            $where .= " (" . $left . ">='" . $prefix . $interval[0] . "' AND " . $left . "<='" . $prefix . $interval[1] . "') ";
                        else
                            $where .= " ((" . $left . ">='" . $prefix . $interval[0] . "' AND " . $left . "<='" . $prefix . $interval[1] . "') OR (" . $right . ">='" . $prefix . $interval[0] . "' AND " . $right . "<='" . $prefix . $interval[1] . "')) ";
                    } else {
                        // интервалов нет
                        if ($prefix == 't' or $prefix == 'a' or $prefix == 'k') {
                            $data_field *= 10;
                        }

                        if ($right == '')
                            $where .= " " . $left . "='" . $data_field . "' ";
                        else
                            $where .= " (" . $left . "='" . $prefix . $data_field . "' AND " . $right . "='" . $prefix . $data_field . "') ";
                    }
                } else {
                    // элемент массива не последний
                    if (strpbrk($data_field, "-")) {
                        // разбираем интервал
                        $interval = explode("-", $data_field);

                        if ($prefix == 't' or $prefix == 'a' or $prefix == 'k') {
                            $interval[0] *= 10;
                            $interval[1] *= 10;
                        }

                        if ($right == '')
                            $where .= " (" . $left . ">='" . $prefix . $interval[0] . "' AND " . $left . "<='" . $prefix . $interval[1] . "') AND ";
                        else
                            $where .= " ((" . $left . ">='" . $prefix . $interval[0] . "' AND " . $left . "<='" . $prefix . $interval[1] . "') OR (" . $right . ">='" . $prefix . $interval[0] . "' AND " . $right . "<='" . $prefix . $interval[1] . "')) AND ";
                    } else {
                        // интервалов нет
                        if ($prefix == 't' or $prefix == 'a' or $prefix == 'k') {
                            $data_field *= 10;
                        }
                        if ($right == '')
                            $where .= " " . $left . "='" . $prefix . $data_field . "' AND ";
                        else
                            $where .= " (" . $left . "='" . $prefix . $data_field . "' AND " . $right . "='" . $prefix . $data_field . "') AND ";
                    }
                }
            }
        } else {
            // WHERE НЕ ПУСТОЙ
            // разбиваем по пробелу полученные данные
            $array_data = explode(" ", $inputData);
            // необходимо обойти каждый элемент массива в цикле и
            // проверяем на наличие диапазона
            $iteration = 0;
            foreach ($array_data as $data_field) {
                $iteration++;
                if ($iteration == count($array_data)) {
                    // значит элемент массива последний
                    // если есть дефис, значит это интервал
                    if (strpbrk($data_field, "-")) {
                        // разбираем интервал
                        $interval = explode("-", $data_field);
                        if ($prefix == 't' or $prefix == 'a' or $prefix == 'k') {
                            $interval[0] *= 10;
                            $interval[1] *= 10;
                        }
                        if ($right == '')
                            $where .= " AND ($left>='$prefix" . $interval[0] . "' AND $left<='$prefix" . $interval[1] . "') ";
                        else
                            $where .= " AND (($left>='$prefix" . $interval[0] . "' AND $left<='$prefix" . $interval[1] . "') OR " . " ($right>='$prefix" . $interval[0] . "' AND $right<='$prefix" . $interval[1] . "')) ";
                    } else {
                        // интервалов нет
                        if ($prefix == 't' or $prefix == 'a' or $prefix == 'k') {
                            $data_field *= 10;
                        }
                        if ($right == '')
                            $where .= " AND $left='$prefix" . $data_field . "' ";
                        else
                            $where .= " AND ($left='$prefix" . $data_field . "' AND $right='$prefix" . $data_field . "') ";
                    }
                } else {
                    // элемент массива не последний
                    if (strpbrk($data_field, "-")) {
                        // разбираем интервал
                        $interval = explode("-", $data_field);
                        if ($prefix == 't' or $prefix == 'a' or $prefix == 'k') {
                            $interval[0] *= 10;
                            $interval[1] *= 10;
                        }
                        $interval = explode("-", $data_field);
                        if ($right == '')
                            $where .= " AND ($left>='$prefix" . $interval[0] . "' AND $left<='$prefix" . $interval[1] . "') AND ";
                        else
                            $where .= " AND (($left>='$prefix" . $interval[0] . "' AND $left<='$prefix" . $interval[1] . "') OR ($right>='$prefix" . $interval[0] . "' AND $right<='$prefix" . $interval[1] . "')) AND ";
                    } else {
                        // интервалов нет
                        if ($prefix == 't' or $prefix == 'a' or $prefix == 'k') {
                            $data_field *= 10;
                        }
                        if ($right == '')
                            $where .= " AND $left='$prefix" . $data_field . "' AND ";
                        else
                            $where .= " AND ($left='$prefix" . $data_field . "' AND $right='$prefix" . $data_field . "') AND ";
                    }
                }
            }
        }
    }

    public function actionGetAllModelsInfo()
    {
        echo Models::model()->GetAllModels();
    }

}
