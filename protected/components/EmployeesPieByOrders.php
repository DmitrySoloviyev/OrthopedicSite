<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 21.09.14
 * Time: 18:13
 */
class EmployeesPieByOrders extends GraphBuilder
{
    public function __construct($title)
    {
        $this->title = $title;
        $this->lineBuilder = new LineBuilder();
        $this->obtainedData = Order::performanceByEmployeeSummaryPie();
    }

    function build()
    {
        $this->preparedData = $this->lineBuilder->buildSimple($this->obtainedData);

        return $this->preparedData;
    }

}
