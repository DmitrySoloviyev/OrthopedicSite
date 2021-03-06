<?php $this->beginContent('/layouts/main'); ?>
<div class="span3">
    <?php $this->widget('bootstrap.widgets.TbNav', [
        'type' => TbHtml::NAV_TYPE_LIST,
        'htmlOptions' => ['class' => 'well mynav'],
        'items' => [
            ['label' => 'Модельеры'],
            ['label' => 'Новый модельер', 'url' => '/admin/user/create', 'class' => 'nav nav-list'],
            ['label' => 'Все модельеры', 'url' => '/admin/user/index', 'class' => 'nav nav-list'],

            ['label' => 'Материалы'],
            ['label' => 'Новый материал', 'url' => '/admin/material/create', 'class' => 'nav nav-list'],
            ['label' => 'Все материалы', 'url' => '/admin/material/index', 'class' => 'nav nav-list'],

            ['label' => 'База данных'],
            ['label' => 'Резервирование', 'url' => '/admin/db/backup', 'class' => 'nav nav-list'],
            ['label' => 'Восстановление', 'url' => '/admin/db/restore', 'class' => 'nav nav-list'],
            ['label' => 'Производительность', 'url' => '/admin/db/optimize', 'class' => 'nav nav-list'],
            TbHtml::menuDivider(),
            ['label' => 'Отчеты'],
            ['label' => 'По заказам', 'url' => '/admin/report/orders', 'class' => 'nav nav-list'],
            ['label' => 'По моделям', 'url' => '/admin/report/models', 'class' => 'nav nav-list'],
        ]
    ]);?>
</div>
<div class="span9">
    <?= $content; ?>
</div>
<?php $this->endContent(); ?>

