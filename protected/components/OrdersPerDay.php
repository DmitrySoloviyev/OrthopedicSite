<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 14.09.14
 * Time: 19:04
 */
class OrdersPerDay extends GraphBuilder
{
    public function __construct($title)
    {
        $this->title = $title;
        $this->lineBuilder = new LineBuilder();
        $this->obtainedData = Order::performanceByDay();
    }

    function build()
    {
        $this->preparedData = $this->lineBuilder->buildLine($this->obtainedData);

        return $this->preparedData;
    }

}
