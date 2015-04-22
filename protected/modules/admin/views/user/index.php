<?php
/* @var $this UserController */
/* @var $model User */
echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, '<h4>Удаление модельера</h4>
При удалении данные о удаляются не полностью. Удаленный модельер не сможет больше войти в систему.
Восстановление возможно только если есть непосредстверрный доступ к серверу БД.');
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
