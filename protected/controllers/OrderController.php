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
        $model = new Models();

        if (isset($_POST['Order'])) {
            $order->attributes = $_POST['Order'];
            $customer->attributes = $_POST['Customer'];
            $model->attributes = $_POST['Models'];

            $transaction = $model->dbConnection->beginTransaction();
            // сохраняем заказчика
            if (!$customer->save()) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Ошибка при добавлении записи!");
            }
            $order->customer_id = $customer->id;

            //записываем модель
            // если чек-бокс отмечен, значит это новая модель, тут просто сохраняем
            // иначе мы должны вписать айдишник существующей модели и проапдейтить ее (возможно пользователь обновил ее данные)
            if ($model->basedID == null) {
                if ($loadImage = CUploadedFile::getInstance($model, 'loadImage')) {
                    $model->loadImage = $loadImage;
                    $model->loadImage->saveAs(Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $model->loadImage->extensionName);
                    $model->ModelPicture = "" . Yii::app()->request->baseUrl . 'assets/OrthopedicGallery/' . time() . "." . $model->loadImage->extensionName;
                }
                $model->save();
                $model->ModelID = $model->id;
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

            // записываем заказ
            if ($model->save()) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', "Запись успешно добавлена!");

                //очищаем поля формы
                $order->unsetAttributes();
                $model->unsetAttributes();
                $customer->unsetAttributes();
            } else {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Ошибка при добавлении записи!");
            }
        }

        $this->render('new', [
            'order' => $order,
            'customer' => $customer,
            'model' => $model,
        ]);
    }

    /**
     * ДЕЙСТВИЕ ПОИСК
     */
    public function actionSearch()
    {
        $model = new Order('search');
        $customersModel = new Customer('search');
        $materialsModel = new Material('search');
        $employeesModel = new Employee('search');
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
                    $js .= " $('td:nth-child(5)').highlight('" . Material::getMaterialShortcutList($meterialId) . "'); ";
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
                    $js .= " $('td:nth-child(11)').highlight('" . Employee::getEmployeeShortcutList($employeeId) . "'); ";
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

            $dataProvider = new CActiveDataProvider(Order::model()->with('model', 'customer'), array(
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
            $quickSearchQuery = explode(' ', $_GET['quickSearchValue']);
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

        $dataProvider = new CActiveDataProvider(Order::model()->with(
                'material',
                'model',
                'sizeLeft',
                'sizeRight',
                'topVolumeLeft',
                'topVolumeRight',
                'ankleVolumeLeft',
                'ankleVolumeRight',
                'kvVolumeLeft',
                'kvVolumeRight',
                'customer',
                'employee',
                'urkLeft',
                'urkRight',
                'heightLeft',
                'heightRight'
            ),[
                'criteria' => $criteria,
                'pagination' => [
                    'pageSize' => 20,
                ],
                'sort' => [
                    'attributes' => [
                        'order_id' => [
                            'asc' => 'order_id ASC',
                            'desc' => 'order_id desc',
                            'default' => 'desc',
                        ],
                        'model_id' => [
                            'asc' => 'model_id asc',
                            'desc' => 'model_id desc',
                            'default' => 'desc',
                        ],
                        'material_id' => [
                            'asc' => 'material_id asc',
                            'desc' => 'material_id desc',
                            'default' => 'desc',
                        ],
                        'employee_id' => [
                            'asc' => 'employee_id asc',
                            'desc' => 'employee_id desc',
                            'default' => 'desc',
                        ],
                        't.date_created' => [
                            'asc' => 't.date_created',
                            'desc' => 't.date_created desc',
                            'default' => 'desc',
                        ],
                    ],
                    'defaultOrder' => [
                        't.date_created' => CSort::SORT_DESC,
                    ]
                ],
            ]);
print_r($dataProvider);
        $this->render('view', ['dataProvider' => $dataProvider]);
    }

    /**
     * ДЕЙСТВИЕ РЕДАКТИРОВАНИЕ
     */
    public function actionUpdate($id)
    {
        $model = Order::model()->with(
            'material',
            'model',
            'sizeLeft',
            'sizeRight',
            'topVolumeLeft',
            'topVolumeRight',
            'ankleVolumeLeft',
            'ankleVolumeRight',
            'kvVolumeLeft',
            'kvVolumeRight',
            'customer',
            'employee',
            'urkLeft',
            'urkRight',
            'heightLeft',
            'heightRight'
        )->findByPk($id);

        if (!$model) {
            throw new CHttpException(404, 'Указанная запись не найдена');
        }

        $customer = Customer::model()->findByPk($model->customer_id);
        $materialsModel = Material::model()->findByPk($model->MaterialID);
        $employeesModel = Employee::model()->findByPk($model->EmployeeID);
        $modelsModel = Models::model()->findByPk($model->ModelID);

        if (isset($_POST['Orders'])) {
            $model->attributes = $_POST['Orders'];
            $materialsModel->attributes = $_POST['Materials'];
            $employeesModel->attributes = $_POST['Employees'];
            $modelsModel->attributes = $_POST['Models'];
            $customer->attributes = $_POST['Customers'];

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

            $customer->CustomerSN = $customer->CustomerSNUpdate;
            $customer->CustomerFN = $customer->CustomerFNUpdate;
            $customer->CustomerP = $customer->CustomerPUpdate;

            $transaction = $model->dbConnection->beginTransaction();
            try {
                // используем транзакцию, чтобы удостовериться в целостности данных
                //записываем заказчика
                $valid = $customer->validate();
                if ($valid) {
                    $customer->save();
                }

                //записываем модель, если чек-бокс отмечен, значит это новая модель, тут просто сохраняем
                // иначе мы должны вписать айдишник существующей модели и проапдейтить ее (возможно пользователь обновил ее данные)
                if ($modelsModel->basedID == null) {
                    $newModel = new Models();
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
                    Yii::app()->user->setFlash('success', "Запись успешно изменена!");

                    //очищаем поля формы
                    $model->unsetAttributes();
                    $materialsModel->unsetAttributes();
                    $employeesModel->unsetAttributes();
                    $modelsModel->unsetAttributes();
                    $customer->unsetAttributes();

                    $this->redirect(array('view'));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Ошибка при редактировании записи!");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Ошибка при редактировании записи!");
                throw $e;
            }
        }

        $this->render('update', array(
            'model' => $model,
            'customersModel' => $customer,
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
        $model = Order::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, 'Запрашиваемая страница не существует.');
        }
        $model->delete();
        $this->redirect(['view']);
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
        $this->render('contact', array('model' => $model));
    }

    /*
	 * ПОДСВЕТКА СЛОВ ПОИСКА
     */
    function jquery_highlight_create($from_post, $num_child)
    {
        $array_field = explode(' ', $from_post);
        $params = "";
        foreach ($array_field as $num) {
            if (strpbrk($num, "-")) {
                $num_interval = explode('-', $num);
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

}
