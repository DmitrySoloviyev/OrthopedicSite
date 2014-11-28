<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 25.08.14
 * Time: 23:52
 */
class LineBuilder
{
    /**
     * Выходной массив
     *
     * @var array
     */
    private $output = [];

    /**
     * Максивальное значение оси Y
     *
     * @var
     */
    protected $max;

    /**
     * Легенда
     *
     * @var array
     */
    protected static $legend = [];


    /**
     * Строит линию графика c заполнением/дополнением кривой графика нулевыми точками
     * в тех случаях, когда между соседними интервал больше 2х дней
     *
     * @param array $input
     * @return array
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
                $this->setMax($input[$i]['orders_count']);
            } else {
                $this->setMax($input[$i]['orders_count']);
                $this->output[] = [$input[$i]['date_created'], (int)$input[$i]['orders_count']];
            }
        }
        $this->generateMax();

        return [$this->output];
    }


    /**
     * Строит график с множеством кривых c заполнением/дополнением кривой графика нулевыми точками
     * в тех случаях, когда между соседними интервал больше 2х дней
     *
     * @param array $input
     * @return array
     */
    public function buildLines(array $input)
    {
        $input = $this->separateEmployees($input);
        $preArray = [];
//        $this->legend[] = 4;
        foreach ($input as $rows) {
            $this->buildLegend($rows);
            $preArray[] = array_shift($this->buildLine($rows));
        }
        $this->generateMax();

        return $preArray;
    }


    /**
     * Обычное перебор данных, не требующее никаких специфичных действий
     *
     * @param array $input
     * @return array
     */
    public function buildSimple(array $input)
    {
        for ($i = 0; $i < count($input); $i++) {
            $this->output[] = [$input[$i]['employee'], (int)$input[$i]['orders_count']];
        }

        return [$this->output];
    }


    /**
     * Конструктор легенды
     *
     * @param $rows
     */
    protected function buildLegend(array $rows)
    {
        foreach ($rows as $item) {
//            if (!array_key_exists($item['employee_id'], $this->legend)) {
//            }
//            $this->legend[$item['employee_id']] = $item['employee'];
//            $this->legend[] = $item;
            self::$legend[] =  11;
        }

        return [11];
    }

    public function getLegend()
    {
        return self::$legend;
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


    private function setMax($count)
    {
        $count = (int)$count;
        if ($this->max < $count)
            $this->max = $count;
    }


    public function getMax()
    {
        return $this->max;
    }


    private function generateMax()
    {
        if ($this->max % 2 == 1)
            $this->max += 1;
        else
            $this->max += 2;
    }


    private function insertZero($date, $preOrPost)
    {
        return [date('Y-m-d', strtotime($preOrPost, strtotime($date))), 0];
    }

}
