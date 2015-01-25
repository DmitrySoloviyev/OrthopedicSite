<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 21.09.14
 * Time: 23:02
 */
class EmployeesByOrdersPerDay extends GraphBuilder
{
    public function __construct($title)
    {
        $this->title = $title;
        $this->obtainedData = Order::performanceByEmployee();
    }

    function build()
    {
        $lineBuilder = new LineBuilder();
        $this->preparedData = $lineBuilder->buildLines($this->obtainedData);
        $this->max = $lineBuilder->getMax();
        $this->legend = $lineBuilder->getLegend();

        return $this->preparedData;
    }

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