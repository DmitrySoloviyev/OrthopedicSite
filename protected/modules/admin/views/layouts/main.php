<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, width=device-width"/>
    <meta name="language" content="ru"/>
    <?php Yii::app()->getModule('admin')->bootstrap->register(); ?>
    <title>Администрирование базы данных ортопедической обуви</title>
    <?php Yii::app()->clientScript->registerCssFile('/css/admin.css'); ?>
</head>

<body>

<div class="container-fluid">
    <div class="wrap">
        <?php $this->widget('bootstrap.widgets.TbNavbar', [
            'brandLabel' => 'Администрирование базы данных ортопедической обуви',
            'fluid' => true,
            'collapse' => true,
            'display' => TbHtml::NAVBAR_DISPLAY_FIXEDTOP,
            'items' => [
                [
                    'class' => 'bootstrap.widgets.TbNav',
                    'items' => [
                        ['label' => 'На сайт', 'url' => '/', 'icon' => 'home'],
                    ],
                ],
            ],
        ]); ?>
        <div class="row-fluid" style="padding-top: 50px"><?= $content ?></div>
    </div>

    <div class="footer navbar-fixed-bottom">
        <div class="container">
            <p class="text-muted pull-left">    
                Copyright &copy; 2013 - <?= date('Y') ?>           by
                <?= CHtml::mailto('Dmitry Soloviyev', 'dmitry.soloviyev@gmail.com') ?>
                                                   
            </p>

            <p class="text-muted pull-right">
                            г. Москва . Все права защищены.
                <?= Yii::powered(); ?>
            </p>
        </div>
    </div>
</div>

</body>
</html>
