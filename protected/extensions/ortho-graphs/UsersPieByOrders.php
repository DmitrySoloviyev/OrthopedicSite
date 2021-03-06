<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 21.09.14
 * Time: 18:13
 * @property array output
 */
class UsersPieByOrders extends GraphBuilder
{
    public function __construct($title)
    {
        $this->title = $title;
        $this->obtainedData = Order::performanceByUserSummaryPie();
    }

    function build()
    {
        $this->preparedData = $this->buildPie($this->obtainedData);

        return $this->preparedData;
    }

    public function buildPie(array $input)
    {
        $output = [];

        for ($i = 0; $i < count($input); $i++) {
            $output[] = [$input[$i]['user'], (int)$input[$i]['orders_count']];
        }

        return [$output];
    }

}
