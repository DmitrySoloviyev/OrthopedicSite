<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 13.09.14
 * Time: 19:22
 */
abstract class GraphBuilder
{
    /**
     * Массив с полученными данными из модели
     *
     * @var
     */
    protected $obtainedData;

    /**
     * Массив с преобразованными данными из модели
     *
     * @var
     */
    protected $preparedData;

    /**
     * Название графика
     *
     * @var
     */
    protected $title = '';

    /**
     * @property LineBuilder
     */
    public $lineBuilder;

    /**
     * Стили точек на графике
     *
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

    public function getTitle()
    {
        return $this->title;
    }

    public function getStyle()
    {
        return $this->styles[rand(0, count($this->styles) - 1)];
    }

    abstract function build();

}
