<?php
/* @var $this ModelController */
/* @var $model Models */
$this->pageTitle = Yii::app()->name . ' -  Просмотр модели №' . $model->name;
$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Модели' => ['model/index'],
        $model->name,
    ],
]);

$this->widget('ext.yii-flash.Flash', [
    'keys' => ['success', 'error'],
]);
?>

<?php $this->widget('bootstrap.widgets.TbTabs', [
    'tabs' => [
        [
            'label' => 'Основная информация',
            'content' => $this->renderPartial('view/_basic', ['model' => $model], true),
            'active' => true
        ],
        [
            'label' => 'Используется в заказах',
            'content' => $this->renderPartial('view/_orders', ['model' => $model], true),
        ],
    ],
]); ?>
