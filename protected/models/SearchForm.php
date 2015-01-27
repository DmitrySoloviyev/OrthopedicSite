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
        $orderAttributes = Order::model()->attributes;
        $modelAttributes = Models::model()->attributes;

        foreach ($orderAttributes as $attr => $val) {
            $orderAttributes[$attr] = $this->query;
        }

        foreach ($modelAttributes as $attr => $val) {
            $modelAttributes[$attr] = $this->query;
        }

        $order = new Order('search');
        $order->setAttributes($orderAttributes);

        $model = new Models('search');
        $model->setAttributes($modelAttributes);

        return [$order->search(), $model->search()];
    }

}
