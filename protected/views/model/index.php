<?php
/* @var $this ModelController */
/* @var $model Models */

$this->pageTitle = Yii::app()->name . ' - Все модели';

$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Все модели',
    ],
]);

$this->widget('zii.widgets.grid.CGridView', [
    'id' => 'models-grid',
    'template' => "{summary}\n{pager}\n{items}\n{pager}",
    'dataProvider' => $model->search(),
    'filter' => $model,
    'itemsCssClass' => 'dboutput dboutputModels',
    'columns' => [
        'name',
        'description',
        'date_created',
        [
            'class' => 'CButtonColumn',
            'header' => 'Действия',
        ],
    ],
]);
