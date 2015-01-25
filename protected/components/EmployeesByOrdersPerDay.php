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
