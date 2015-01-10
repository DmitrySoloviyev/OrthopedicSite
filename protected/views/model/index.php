<?php
/* @var $this ModelController */
/* @var $model Models */

$this->pageTitle = Yii::app()->name . ' - Все модели';

$this->widget('zii.widgets.grid.CGridView', [
    'id' => 'models-grid',
    'template' => "{summary}\n{pager}\n{items}\n{pager}",
    'dataProvider' => $model->search(),
    'filter' => $model,
    'itemsCssClass' => 'dboutput',
    'columns' => [
        'name',
        'description' => [
            'name' => 'description',
            'htmlOptions' => ['width' => '500px']
        ],
        'comment',
//        'picture',
        'date_created',
        'date_modified',
        [
            'class' => 'CButtonColumn',
            'header' => 'Действия',
        ],
    ],
]);
