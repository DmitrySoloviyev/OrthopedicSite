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
        $this->lineBuilder = new LineBuilder();
        $this->obtainedData = Order::performanceByEmployee();
    }

    function build()
    {
        $this->preparedData = $this->lineBuilder->buildLines($this->obtainedData);

        return $this->preparedData;
    }

}
