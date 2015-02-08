<?php
/* @var $this UserController */
/* @var $model User */
?>

<h1>Модельеры</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'user-grid',
    'type' => 'striped condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        'surname',
        'name',
        'patronymic',
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
