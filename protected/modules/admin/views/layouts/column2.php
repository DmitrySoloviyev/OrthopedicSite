<?php $this->beginContent('/layouts/main'); ?>
<div class="span3">
    <?php $this->widget('bootstrap.widgets.TbNav', [
        'type' => TbHtml::NAV_TYPE_LIST,
        'htmlOptions' => ['class' => 'well mynav'],
        'items' => [
            ['label' => 'Модельеры'],
            ['label' => 'Новый модельер', 'url' => '/admin/employee/create', 'class' => 'nav nav-list'],
            ['label' => 'Все модельеры', 'url' => '/admin/employee/index', 'class' => 'nav nav-list'],

            ['label' => 'Материалы'],
            ['label' => 'Новый материал', 'url' => '/admin/material/create', 'class' => 'nav nav-list'],
            ['label' => 'Все материалы', 'url' => '/admin/material/index', 'class' => 'nav nav-list'],

            ['label' => 'Модели'],
            ['label' => 'Новая модель', 'url' => '/admin/model/create', 'class' => 'nav nav-list'],
            ['label' => 'Все модели', 'url' => '/admin/model/index', 'class' => 'nav nav-list'],

            ['label' => 'База данных'],
            ['label' => 'Резервирование', 'url' => '/admin/db/backup', 'class' => 'nav nav-list'],
            ['label' => 'Восстановление', 'url' => '/admin/db/restore', 'class' => 'nav nav-list'],
            TbHtml::menuDivider(),
            ['label' => 'Отчеты'],
            ['label' => 'Все заказы', 'url' => '/admin/report/index', 'class' => 'nav nav-list'],
        ]
    ]);?>
</div>
<div class="span9">
    <?= $content; ?>
</div>
<?php $this->endContent(); ?>

