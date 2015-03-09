<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 13.09.14
 * Time: 19:22
 */
abstract class GraphBuilder extends CComponent
{
    /**
     * Массив с полученными данными из модели
     * @var
     */
    protected $obtainedData;

    /**
     * Массив с преобразованными данными из модели
     * @var
     */
    protected $preparedData;

    /**
     * Название графика
     * @var
     */
    protected $title = '';

    /**
     * Стили точек на графике
     * @var array
     */
    protected $styles = [
        'diamond',
        'circle',
        'square',
        'x',
        'plus',
        'filledDiamond',
        'filledCircle',
        'filledSquare'
    ];

    /**
     * Максивальное значение оси Y
     * @var
     */
    protected $max;

    /**
     * Легенда
     * @var array
     */
    protected $legend = [];

    /**
     * Название графика
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Разндомный стиль точек графика
     * @return mixed
     */
    public function getStyle()
    {
        return $this->styles[rand(0, count($this->styles) - 1)];
    }


    public function getMax()
    {
        return $this->max;
    }

    public function getLegend()
    {
        return $this->legend;
    }

    abstract function build();

}
