<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 03.08.14
 * Time: 11:22
 */
class Restore extends CFormModel
{
    public $dump;

    public function rules()
    {
        return [
            ['dump', 'file', 'types' => 'sql'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'dump' => 'Снимок базы данных',
        ];
    }

}
