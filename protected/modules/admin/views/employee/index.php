<?php
/* @var $this EmployeeController */
/* @var $model Employee */
?>

<h1>Модельеры</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'employee-grid',
    'type' => 'striped condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        'surname',
        'name',
        'patronymic',
        'date_created',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
            'template' => '{update} &nbsp; {delete}',
        ],
    ],
]); ?>
