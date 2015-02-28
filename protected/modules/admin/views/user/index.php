<?php
/* @var $this UserController */
/* @var $model User */
?>

<h1>Модельеры</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'user-grid',
    'type' => TbHtml::GRID_TYPE_STRIPED,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        'surname',
        'name',
        'patronymic',
        'login',
        'is_deleted' => [
            'name' => 'is_deleted',
            'value' => '$data->isDeletedLabel()',
        ],
        'date_created',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
            'template' => '{update} &nbsp; {delete}',
        ],
    ],
]); ?>
