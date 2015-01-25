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
        $this->obtainedData = Order::performanceByDay();
    }

    function build()
    {
        $lineBuilder = new LineBuilder();
        $this->preparedData = $lineBuilder->buildLine($this->obtainedData);
        $this->max = $lineBuilder->getMax();

        return $this->preparedData;
    }

}
