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
    'type' => TbHtml::GRID_TYPE_STRIPED,
    'template' => "{summary}\n{pager}\n{items}\n{pager}",
    'dataProvider' => $model->search(),
    'pager' => [
        'class' => 'bootstrap.widgets.TbPager',
        'maxButtonCount' => 12,
        'pageSize' => 20,
        'htmlOptions' => [
            'align' => TbHtml::PAGINATION_ALIGN_CENTER
        ],
    ],
    'filter' => $model,
    'columns' => [
        'name',
        'description',
        [
            'name' => 'author_id',
            'value' => '$data->author->fullName()',
        ],
        'date_created' => [
            'name' => 'date_created',
            'value' => '$data->hiddmmyyyy($data->date_created)',
            'filter' => false,
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
            'template'=>'{view} &nbsp; {update} &nbsp; {delete}',
        ],
    ],
]);
