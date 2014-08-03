<?php
/* @var $this ModelController */
/* @var $model Models */
?>

<h1>Модели</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'models-grid',
    'type' => 'striped condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        'name',
        'description',
        'date_created',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
            'template' => '{view} &nbsp; {update} &nbsp; {delete}',
        ],
    ],
]); ?>
