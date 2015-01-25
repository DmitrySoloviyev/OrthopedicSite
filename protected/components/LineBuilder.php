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
        }
        $this->legend = $this->buildLegend();
//print_r($input);
        return $preArray;
    }
    /*
$sorted_employee_id = array();
$employee_fio = array();

for ($i = 0; $i < count($result2); $i++) {
    if (!array_key_exists($result2[$i]['EmployeeID'], $employee_fio))
        $employee_fio[$result2[$i]['EmployeeID']] = $result2[$i]['FIO'];

    if (array_key_exists($result2[$i]['EmployeeID'], $sorted_employee_id)) {
        $sorted_employee_id[$result2[$i]['EmployeeID']] .= ", ['" . $result2[$i]['DAYDATE'] . "', " . $result2[$i]['COUNT'] . "]";
    } else {
        $sorted_employee_id[$result2[$i]['EmployeeID']] = "['" . $result2[$i]['DAYDATE'] . "', " . $result2[$i]['COUNT'] . "]";
    }

    // необходимо отслеживать разницу в днях, только если в следующей ячейке тот же самый модельер
    $next_cell_2 = $i + 1;
    if (isset($result2[$next_cell_2]) && ($result2[$i]['EmployeeID'] == $result2[$next_cell_2]['EmployeeID'])) {
        $datetime1 = date_create($result2[$i]['DAYDATE']);
        $datetime2 = date_create($result2[$next_cell_2]['DAYDATE']);
        $interval2 = date_diff($datetime1, $datetime2);
        $days_missing_2 = $interval2->format('%d');
        if ($days_missing_2 >= 2) {
            $sorted_employee_id[$result2[$i]['EmployeeID']] .= ", ['" . date("Y-m-d", strtotime(' + 1 day', strtotime($result2[$i]['DAYDATE']))) . "', 0]";
            $sorted_employee_id[$result2[$i]['EmployeeID']] .= ", ['" . date("Y-m-d", strtotime(' - 1 day', strtotime($result2[$next_cell_2]['DAYDATE']))) . "', 0]";
        }
    } else {
        $days_missing_2 = 0;
    }
}
 * */


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
