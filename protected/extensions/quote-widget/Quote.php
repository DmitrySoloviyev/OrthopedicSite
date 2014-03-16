<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 16.03.14
 * Time: 16:40
 */
class Quote extends CWidget
{
    public $class = 'mytext';
    private $text;

    public function init()
    {
        $assetsDir = dirname(__FILE__) . '/assets';
        Yii::app()->clientScript->registerCssFile(Yii::app()->assetManager->publish($assetsDir . '/quote.css'));

        // TODO кэшировать!!!
        $quotes = file($assetsDir . '/quotes.txt');
        if ($quotes) {
            $cnt = count($quotes);
            $this->text = $quotes[rand(0, --$cnt)];
        } else {
            $this->text = 'Дешевая пара обуви — плохая экономия. Не экономьте на главном: обувь — основа вашего
                    гардероба. <br />&copy; Джорджио Армани.';
        }
    }

    public function run()
    {
        $this->render('quote', [
            'text' => $this->text,
        ]);
    }

}
