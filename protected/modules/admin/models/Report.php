<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 16.08.14
 * Time: 20:06
 */

Yii::import('ext.phpexcel.XPHPExcel');

class Report extends CFormModel
{
    public $dateStart;
    public $dateEnd;

    public function rules()
    {
        return [
            ['dateStart, dateEnd', 'date', 'format' => 'dd.MM.yyyy'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'dateStart' => 'Начальная дата',
            'dateEnd' => 'Конечная дата',
        ];
    }


    public function generateMain()
    {
        $start = $this->dateStart;
        $end = $this->dateEnd;

        $starts = $start; // формат даты для вывода в шапке таблицы
        $ends = $end; // формат даты для вывода в шапке таблицы

        $start .= ' 00:00:00';
        $end .= ' 23:59:59';
        $start = date('Y-m-d H-i-s', strtotime($start));
        $end = date('Y-m-d H-i-s', strtotime($end));

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
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setItalic(true);
        $sheet->mergeCells('A1:S1');


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


        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('t.date_created', $start, $end, 'AND');
        $criteria->order = 't.date_created DESC';
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
            'urkLeft',
            'urkRight',
            'heightLeft',
            'heightRight'
        )->findAll($criteria);

        //  заполняем документ заказами:
        foreach ($data as $value) {
            static $i = 4;
            /** @var $value Order */
            $sheet->setCellValue("A" . $i, $value->order_id)
                ->getStyle("A" . $i);

            $sheet->setCellValue("B" . $i, $value->model->name)
                ->getStyle("B" . $i);

            $sheet->setCellValue("C" . $i, $value->sizeLeft->size)
                ->getStyle("C" . $i);

            $sheet->setCellValue("D" . $i, $value->sizeRight->size)
                ->getStyle("D" . $i);

            $sheet->setCellValue("E" . $i, $value->urkLeft->urk)
                ->getStyle("E" . $i);

            $sheet->setCellValue("F" . $i, $value->urkRight->urk)
                ->getStyle("F" . $i);

            $sheet->setCellValue("G" . $i, $value->material->material_name)
                ->getStyle("G" . $i);

            $sheet->setCellValue("H" . $i, $value->heightLeft->height)
                ->getStyle("H" . $i);

            $sheet->setCellValue("I" . $i, $value->heightRight->height)
                ->getStyle("I" . $i);

            $sheet->setCellValue("J" . $i, $value->topVolumeLeft->volume)
                ->getStyle("J" . $i);

            $sheet->setCellValue("K" . $i, $value->topVolumeRight->volume)
                ->getStyle("K" . $i);

            $sheet->setCellValue("L" . $i, $value->ankleVolumeLeft->volume)
                ->getStyle("L" . $i);

            $sheet->setCellValue("M" . $i, $value->ankleVolumeRight->volume)
                ->getStyle("M" . $i);

            $sheet->setCellValue("N" . $i, $value->kvVolumeLeft->volume)
                ->getStyle("N" . $i);

            $sheet->setCellValue("O" . $i, $value->kvVolumeRight->volume)
                ->getStyle("O" . $i);

            $sheet->setCellValue("P" . $i, $value->customer->fullName())
                ->getStyle("P" . $i);

            $sheet->setCellValue("Q" . $i, $value->employee->fullName())
                ->getStyle("Q" . $i);

            $sheet->setCellValue("R" . $i, $value->date_created)->getStyle("R" . $i);
            $sheet->setCellValue("S" . $i, $value->comment)->getStyle("S" . $i);

            $sheet->getRowDimension($i)->setRowHeight(28);
            ++$i;
        }


        $file_name = 'orders_' . time() . '.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
        // Выводим содержимое excel-файла
        $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel5');
        $objWriter->save('php://output');

    }

}
