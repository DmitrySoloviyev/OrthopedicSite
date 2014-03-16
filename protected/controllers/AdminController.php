<?php

class AdminController extends Controller
{
    public function actionIndex()
    {
        $employee = new Employee();
        $material = new Material();

        $this->render('index', [
            'employee' => $employee,
            'material' => $material,
        ]);
    }

    public function actionOptimize()
    {
        if (isset($_POST['optimizeDbBtn'])) {
            $connection = Yii::app()->db;
            $command = $connection->createCommand('OPTIMIZE TABLE orders, employees, customers, materials, sizes, urks, heights, top_volume, ankle_volume, kv_volume, models');
            $result = $command->execute();
            if ($result)
                Yii::app()->user->setFlash('success', "Оптимизация успешно завершена!");
            else
                Yii::app()->user->setFlash('success', "Оптимизация не выполнена!");
        }

        Yii::app()->request->redirect(Yii::app()->createUrl('admin/index'));
    }

    public function actionBackupDb()
    {
        if (isset($_POST['backupDbBtn'])) {
            $now = date("_Y-n-d__H-i-s");
            $filename = "BACKUP_ORTHO_DB_" . $now . ".sql";
            $command = "mysqldump --flush-logs --lock-tables --databases -u" . Yii::app()->db->username . " -p" . Yii::app()->db->password . " -hlocalhost ortho_db > $filename";
            $result = system($command);
            if (!$result) {
                ob_clean();
                header("Content-Type: text/plain;");
                header("Content-Disposition: attachment; filename='$filename'");
                echo file_get_contents($filename);
                unlink($filename);
                Yii::app()->end();
            }
        }
    }

    public function actionRecoveryDb()
    {
        if (isset($_POST['recoveryDbBtn'])) {
            if (($_FILES['recoveryDb']['type'] == 'text/x-sql' OR $_FILES['recoveryDb']['type'] == 'application/octet-stream') AND $_FILES['recoveryDb']['error'] == 0) {
                $tmp = $_FILES['recoveryDb']['tmp_name'];
                $name = $_FILES['recoveryDb']['name'];
                move_uploaded_file($tmp, $name);

                $command = "mysql -u" . Yii::app()->db->username . " -p" . Yii::app()->db->password . " SHOES < $name";
                $result = system($command);
                unlink("$name");
                if (!$result) {
                    Yii::app()->user->setFlash('success', "База Данных успешно восстановлена из резервной копии!");
                } else {
                    Yii::app()->user->setFlash('error', "Ошибка восстановления базы данных.");
                }
            } else {
                Yii::app()->user->setFlash('error', "Ошибка загрузки файла. Файл неверного расширения или содержит ошибки.");
            }
        }

        Yii::app()->request->redirect(Yii::app()->createUrl('admin/index'));
    }

    public function actionGenerateExcel()
    {
        if (isset($_POST['saveAsExcel'])) {
            $start = $_POST['startDate'];
            $end = $_POST['endDate'];

            // проверка, что выбранная конечная дата больше начальной
            if ((strtotime($end) - strtotime($start)) < 0) {
                Yii::app()->user->setFlash('error', "Ошибка! Начальная дата больше конечной!");
                Yii::app()->request->redirect(Yii::app()->createUrl('admin/index'));
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
                $styleTop = [
                    'borders' => [
                        'bottom' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000']
                        ],
                        'top' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000']
                        ],
                        'left' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000']
                        ],
                        'right' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000']
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    ],
                ];

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

                $styleMergeTopLeft = [
                    'borders' => [
                        'bottom' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000']
                        ],
                        'top' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000']
                        ],
                        'left' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000']
                        ],
                        'right' => [
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    ],
                ];

                $styleMergeTopRight = [
                    'borders' => [
                        'bottom' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000']
                        ],
                        'top' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000']
                        ],
                        'left' => [
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ],
                        'right' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000']
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    ],
                ];

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
                $arrayABGPQRS = [
                    'borders' => [
                        'bottom' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => [
                                'rgb' => '333333'
                            ]
                        ],
                        'top' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => [
                                'rgb' => '333333'
                            ]
                        ],
                        'left' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => [
                                'rgb' => '333333'
                            ]
                        ],
                        'right' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => [
                                'rgb' => '333333'
                            ]
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wrap' => true,
                    ],
                ];

                // левые смежные ячейки
                $arrayCEHJLN = [
                    'borders' => [
                        'bottom' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '333333']
                        ],
                        'top' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '333333']
                        ],
                        'left' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '333333']
                        ],
                        'right' => [
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => ['rgb' => '333333']
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wrap' => true,
                    ],
                ];

                // правые смежные ячейки
                $arrayDFIKMO = [
                    'borders' => [
                        'bottom' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '333333']
                        ],
                        'top' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '333333']
                        ],
                        'left' => [
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => ['rgb' => '333333']
                        ],
                        'right' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '333333']
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wrap' => true,
                    ],
                ];

                // запрос в базу
                $criteria = new CDbCriteria;
                $criteria->addBetweenCondition('date_created', $start, $end, 'AND');
                $criteria->order = 'date_created DESC';
                $data = Order::model()->with(
                    'model',
                    'material',
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
                )->findAll($criteria);

                if (!$data) {
                    Yii::app()->user->setFlash('error', "Нет заказов!");
                }

                //  заполняем документ заказами:
                foreach ($data as $value) {
                    static $i = 4;

                    $sheet->setCellValue("A" . $i, $value->order_id)
                        ->getStyle("A" . $i)->applyFromArray($arrayABGPQRS);

                    $sheet->setCellValue("B" . $i, $value->model->name)
                        ->getStyle("B" . $i)->applyFromArray($arrayABGPQRS);

                    $sheet->setCellValue("C" . $i, $value->sizeLEFT->size)
                        ->getStyle("C" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("D" . $i, $value->sizeRIGHT->size)
                        ->getStyle("D" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("E" . $i, $value->urkLEFT->urk)
                        ->getStyle("E" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("F" . $i, $value->urkRIGHT->urk)
                        ->getStyle("F" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("G" . $i, $value->material->material)
                        ->getStyle("G" . $i)->applyFromArray($arrayABGPQRS);

                    $sheet->setCellValue("H" . $i, $value->heightLEFT->height)
                        ->getStyle("H" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("I" . $i, $value->heightRIGHT->height)
                        ->getStyle("I" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("J" . $i, $value->topVolumeLEFT->value)
                        ->getStyle("J" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("K" . $i, $value->topVolumeRIGHT->value)
                        ->getStyle("K" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("L" . $i, $value->ankleVolumeLEFT->value)
                        ->getStyle("L" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("M" . $i, $value->ankleVolumeRIGHT->value)
                        ->getStyle("M" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("N" . $i, $value->kvVolumeLEFT->value)
                        ->getStyle("N" . $i)->applyFromArray($arrayCEHJLN);

                    $sheet->setCellValue("O" . $i, $value->kvVolumeRIGHT->value)
                        ->getStyle("O" . $i)->applyFromArray($arrayDFIKMO);

                    $sheet->setCellValue("P" . $i, $value->customer->fullName())
                        ->getStyle("P" . $i)->applyFromArray($arrayABGPQRS);

                    $sheet->setCellValue("Q" . $i, $value->employee->fullName())
                        ->getStyle("Q" . $i)->applyFromArray($arrayABGPQRS);

                    $sheet->setCellValue("R" . $i, $value->date_created)->getStyle("R" . $i)->applyFromArray($arrayABGPQRS);
                    $sheet->setCellValue("S" . $i, $value->comment)->getStyle("S" . $i)->applyFromArray($arrayABGPQRS);

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
    }

}
