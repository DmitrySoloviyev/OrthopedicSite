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
        'title',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
            'template' => '{update} &nbsp; {delete}',
        ],
    ],
]); ?>
