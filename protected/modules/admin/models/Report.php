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

    private $objPHPExcel;
    private $worksheet;
    private $row_it;
    private $cell_it;

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

    public function behaviors()
    {
        return [
            'DateTimeFormatBehavior' => [
                'class' => 'DateTimeFormatBehavior',
            ],
        ];
    }

    private function dateFormat()
    {
        $this->dateStart = $this->dateStart . ' 00:00:00';
        $this->dateEnd = $this->dateEnd . ' 23:59:59';
    }

    public function generateByOrders()
    {
        $this->dateFormat();
        $data = Order::report($this->dateStart, $this->dateEnd);

        $headers = array_keys($data[0]);

        unset($headers[array_search('order_id', $headers)]);
        unset($headers[array_search('model_id', $headers)]);

        $this->initPHPExcel($headers,
            'Заказы',
            'Таблица заказов за период с ' . self::hiddmmyyyy($this->dateStart) . ' по ' . self::hiddmmyyyy($this->dateEnd));

        foreach ($data as $row) {
            $this->cell_it = $this->row_it->current()->getCellIterator();

            $order_id = 0;
            $model_id = 0;
            foreach ($row as $key => $val) {
                if ($key == 'order_id') {
                    $order_id = $val;
                    continue;
                }
                if ($key == 'model_id') {
                    $model_id = $val;
                    continue;
                }
                if ($key == '№ Заказа') {
                    $this->cell_it->current()->getHyperlink()->setUrl(Yii::app()->createAbsoluteUrl('/order/view', ['id'=>$order_id]));
                }
                if ($key == 'Модель') {
                    $this->cell_it->current()->getHyperlink()->setUrl(Yii::app()->createAbsoluteUrl('/model/view', ['id'=>$model_id]));
                }

                if ($key == 'Дата создания')
                    $val = self::hiddmmyyyy($val);
                if ($key == 'Удалено')
                    $val = $val ? 'Да' : 'Нет';

                $this->cell_it->current()->setValue($val);
                $this->cell_it->next();
            }

            $this->row_it->next();
        }

        $this->download('orders_' . date('dmyhis', time()));
    }

    public function generateByModels()
    {
        $this->dateFormat();
        $data = Models::report($this->dateStart, $this->dateEnd);
        $this->initPHPExcel(array_keys($data[0]),
            'Модели',
            'Таблица моделей за период с ' . self::hiddmmyyyy($this->dateStart) . ' по ' . self::hiddmmyyyy($this->dateEnd));

        foreach ($data as $row) {
            $this->cell_it = $this->row_it->current()->getCellIterator();

            foreach ($row as $key => $val) {
                if ($key == 'Дата создания')
                    $val = self::hiddmmyyyy($val);
                if ($key == 'Удалено')
                    $val = $val ? 'Да' : 'Нет';
                $this->cell_it->current()->setValue($val);
                $this->cell_it->next();
            }

            $this->row_it->next();
        }

        $this->download('models_' . date('dmyhis', time()));
    }


    public function initPHPExcel($headers, $worksheetTitle, $reportTitle)
    {
        $this->objPHPExcel = XPHPExcel::createPHPExcel();
        $this->worksheet = $this->objPHPExcel->getActiveSheet();
        $this->worksheet->setTitle($worksheetTitle);

        $this->row_it = $this->worksheet->getRowIterator();
        $row_index = $this->row_it->current()->getRowIndex();

        $this->row_it->next();
        $this->row_it->next();
        $this->cell_it = $this->row_it->current()->getCellIterator();

        $styleArray = [
            'borders' => [
                'outline' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ]
            ],
            'alignment' => [
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ],
            'font' => [
                'bold' => true
            ],
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => [
                    'argb' => 'EBF1DE',
                ]
            ]
        ];

        foreach ($headers as $header) {
            $this->cell_it->current()->setValue($header);
            $coordianate = $this->cell_it->current()->getCoordinate();
            $this->worksheet->getStyle($coordianate)->applyFromArray($styleArray);
            $this->worksheet->getStyle($coordianate)->getAlignment()->setWrapText(true);
            $this->worksheet->getColumnDimension($this->cell_it->current()->getColumn())->setAutoSize(true);
            $this->cell_it->next();
        }

        $max_col = $this->worksheet->getHighestColumn();

        $merge_cells = "A1:" . $max_col . $row_index;
        $this->worksheet->mergeCells("A1:" . $max_col . $row_index);
        $this->worksheet->setCellValue('A1', $reportTitle);
        $this->worksheet->getStyle("A1")->getFont()->setBold(true);

        $style = [
            'alignment' => [
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $this->worksheet->getStyle($merge_cells)->applyFromArray($style);
        $this->row_it->next();
    }

    private function download($filename)
    {
        $styleArray = [
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ]
            ],
            'alignment' => [
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ]
        ];

        $this->worksheet->getStyle('A1:' . $this->worksheet->getHighestColumn() . $this->worksheet->getHighestRow())->applyFromArray($styleArray);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-transfer-encoding: binary');
        header('Content-Disposition: attachment;filename=' . $filename . '.xls');
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
