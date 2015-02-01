<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 11.01.15
 * Time: 16:40
 *
 * @property string $query
 */
class SearchForm extends CFormModel
{
    public $query;

    public function rules()
    {
        return [
            ['query', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'query' => 'Запрос',
        ];
    }

    public function search()
    {
        $order = new Order('search');
        $model = new Models('search');

        return [$order->siteSearch($this->query), $model->siteSearch($this->query)];
    }

}
