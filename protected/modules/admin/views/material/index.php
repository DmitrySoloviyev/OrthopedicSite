<?php
/* @var $this MaterialController */
/* @var $model Material */
?>

<h1>Материалы</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'material-grid',
    'type' => TbHtml::GRID_TYPE_STRIPED,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        'title',
        'date_created' => [
            'name' => 'date_created',
            'value' => '$data->hiddmmyyyy($data->date_created)',
            'filter' => false,
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
            'template' => '{update} &nbsp; {delete}',
        ],
    ],
]); ?>
