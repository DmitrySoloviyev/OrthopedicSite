<?php
/* @var $this ModelController */
/* @var $model Models */

$this->widget('zii.widgets.grid.CGridView', [
    'id' => 'models-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        'id',
        'name',
        'description',
//        'picture',
        'date_created',
        'date_modified',
        /*
        'is_deleted',
        */
        [
            'class' => 'CButtonColumn',
        ],
    ],
]);
