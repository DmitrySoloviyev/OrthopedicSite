<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 25.08.14
 * Time: 23:52
 */
class LineBuilder
{
    private $max = [];
    private $legend = [];

    /**
     * Выходной массив
     * @var array
     */
    private $output = [];


    public function getMax()
    {
        return $this->generateMax(max($this->max));
    }

    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * Строит линию графика c заполнением/дополнением кривой графика нулевыми точками
     * в тех случаях, когда между соседними интервал больше 2х дней
     *
     * @param array $input
     * @return array
     * @internal param $max
     */
    public function buildLine(array $input)
    {
        for ($i = 0; $i < count($input); $i++) {
            $next_cell = $i + 1;
            if (isset($input[$next_cell]['date_created'])) {
                if ($this->neededPeriod($input[$i]['date_created'], $input[$next_cell]['date_created'])) {
                    $this->output[] = $this->insertZero($input[$i]['date_created'], ' + 1 day');
                    $this->output[] = $this->insertZero($input[$next_cell]['date_created'], ' - 1 day');
                }
                $this->output[] = [$input[$i]['date_created'], (int)$input[$i]['orders_count']];
                $this->max[] = $input[$i]['orders_count'];
            } else {
                $this->max[] = $input[$i]['orders_count'];
                $this->output[] = [$input[$i]['date_created'], (int)$input[$i]['orders_count']];
            }
        }

        return [$this->output];
    }

    /**
     * Строит график с множеством кривых c заполнением/дополнением кривой графика нулевыми точками
     * в тех случаях, когда между соседними интервал больше 2х дней
     *
     * @param array $input
     * @return array
     * @internal param $max
     * @internal param $legend
     */
    public function buildLines(array $input)
    {
        $input = $this->separateEmployees($input);
        $preArray = [];
        foreach ($input as $rows) {
            $this->makeLegend($rows);
            $preArray[] = array_shift($this->buildLine($rows));
            $this->output = [];
        }
        $this->legend = $this->buildLegend();

        return $preArray;
    }


    /**
     * Сбор информации для легенды
     * @param $rows
     */
    private function makeLegend($rows)
    {
        foreach ($rows as $row) {
            if (!array_key_exists($row['employee_id'], $this->legend)) {
                $this->legend[$row['employee_id']] = $row['employee'];
            }
        }
    }

    /**
     * Конструктор легенды
     * @return array
     */
    protected function buildLegend()
    {
        $output = [];
        foreach ($this->legend as $employee) {
            $output[] = ['label' => $employee];
        }

        return $output;
    }

    /**
     * Разделение информации по сотрудникам
     *
     * @param array $input
     * @return array
     */
    private function separateEmployees(array $input)
    {
        $sortedArray = [];
        foreach ($input as $row) {
            $sortedArray[$row['employee_id']][] = $row;
        }

        return $sortedArray;
    }

    /**
     * Если количество дней между датами больше 2-х, возвращаем true, иначе false
     *
     * @param $dateStart
     * @param $dateEnd
     * @return bool
     */
    protected function neededPeriod($dateStart, $dateEnd)
    {
        $interval = date_diff(date_create($dateStart), date_create($dateEnd));
        $days_missing = $interval->format('%d');

        return ($days_missing >= 2) ? true : false;
    }

    /**
     * Максимальное значение для столбца Y
     * @param $max
     * @return int
     */
    private function generateMax($max)
    {
        if (($max % 2) == 1)
            return ($max += 1);

        return ($max += 2);
    }


    private function insertZero($date, $preOrPost)
    {
        return [date('Y-m-d', strtotime($preOrPost, strtotime($date))), 0];
    }

}
