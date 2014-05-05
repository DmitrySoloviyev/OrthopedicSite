<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 13.04.14
 * Time: 22:47
 */
class TestCase extends CDbTestCase
{
    public function sendPost($request, $data)
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }

        $ch = curl_init(Yii::app()->createUrl($request));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen($data)]);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

}
