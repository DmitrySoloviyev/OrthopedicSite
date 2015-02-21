<?php
/* @var $this ModelController */
/* @var $model Models */

$this->pageTitle = Yii::app()->name . ' - Все модели';

$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Все модели',
    ],
]);

$this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'models-grid',
    'template' => "{summary}\n{pager}\n{items}\n{pager}",
    'dataProvider' => $model->search(),
    'filter' => $model,
//    'itemsCssClass' => 'dboutput dboutputModels',
    'columns' => [
        'name',
        'description',
        [
            'name' => 'author_id',
            'value' => '$data->author->fullName()',
        ],
        'date_created',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
        ],
    ],
]);
