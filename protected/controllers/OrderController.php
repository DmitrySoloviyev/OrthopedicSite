<?php

class OrderController extends Controller
{
    public function actions()
    {
        return [
            'page' => [
                'class' => 'CViewAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $employee = new Employee();

        $employee->unsetAttributes();
        $this->render('index', [
            'employee' => $employee,
        ]);
    }

    /**
     * ДЕЙСТВИЕ НОВЫЙ ЗАКАЗ
     */
    public function actionNew()
    {
        $order = new Order();
        $customer = new Customer();
        $material = new Material();
        $employee = new Employee();
        $model = new Model();

        if (isset($_POST['Order'])) {
            $order->attributes = $_POST['Order'];
            $customer->attributes = $_POST['Customer'];
            $material->attributes = $_POST['Material'];
            $employee->attributes = $_POST['Employee'];
            $model->attributes = $_POST['Model'];

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

            $model->MaterialID = $material->MaterialID;
            $model->EmployeeID = $employee->EmployeeID;

            //пишем заказчика и модель в соответствующие таблицы, если ок, то заполняем таблицу заказов
            $transaction = $model->dbConnection->beginTransaction();
            try {
                // используем транзакцию, чтобы удостовериться в целостности данных
                //записываем заказчика
                $valid = $customer->validate();
                if ($valid) {
                    $customer->save();
                    $model->CustomerID = $customer->CustomerID;
                }

                //записываем модель
                // если чек-бокс отмечен, значит это новая модель, тут просто сохраняем
                // иначе мы должны вписать айдишник существующей модели и проапдейтить ее (возможно пользователь обновил ее данные)
                if ($model->basedID == null) {
                    if ($loadImage = CUploadedFile::getInstance($model, 'loadImage')) {
                        $model->loadImage = $loadImage;
                        $model->loadImage->saveAs(Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $modelsModel->loadImage->extensionName);
                        $model->ModelPicture = "" . Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $modelsModel->loadImage->extensionName;
                    }
                    $modelsModel->save();
                    $model->ModelID = $modelsModel->ModelID;
                } else {
                    // это запрос на изменение картинки существующей модели
                    $model->ModelID = $model->basedID;
                    $newDescroption = $model->ModelDescription;
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
                    $material->unsetAttributes();
                    $employee->unsetAttributes();
                    $modelsModel->unsetAttributes();
                    $customer->unsetAttributes();
                    $model->Size = null;
                    $model->Urk = null;
                    $model->Height = null;
                    $model->TopVolume = null;
                    $model->AnkleVolume = null;
                    $model->KvVolume = null;
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Ошибка при добавлении записи!");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Ошибка при добавлении записи!");
                throw $e;
            }
        }

        $this->render('new', ['order' => $order,
            'customer' => $customer,
            'material' => $material,
            'employee' => $employee,
            'model' => $model,
        ]);
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

    public function loadModel($id)
    {
        $model = Order::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая страница не существует.');
        return $model;
    }

    public function actionGetModels($term)
    {
        echo Model::model()->getModelNames($term);
    }

    public function actionGetModelInfo()
    {
        echo Model::model()->getModels($_POST['modelName']);
    }

    public function actionGetModelInfoById()
    {
        echo Model::model()->getModelById($_POST['id']);
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
