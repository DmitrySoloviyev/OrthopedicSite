<?php
/* @var $this MaterialController */
/* @var $model Material */
?>

<h1>Материалы</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'material-grid',
    'type' => 'striped condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        'material_name',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
            'template' => '{update} &nbsp; {delete}',
        ],
    ],
]); ?>
