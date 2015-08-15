<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 17.05.15
 * Time: 14:24
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, width=device-width"/>
    <meta name="language" content="ru"/>
    <title><?= CHtml::encode($this->pageTitle) ?></title>
    <?= Yii::app()->bootstrap->register(); ?>
    <?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript
        ->registerCssFile('/css/main.css')
        ->registerCssFile('/css/form.css')
        ->registerCssFile('/css/style.css')
        ->registerCssFile('/css/bootstrap-override.css')
        ->registerScriptFile('/js/main.js', CClientScript::POS_END);
    ?>
</head>

<body>
<div class="container-fluid">
    <div class="page-wrap">
        <code class="version"><?= Yii::app()->params['version'] ?></code>

        <div id="header">
            <div id="logo"><?= CHtml::encode(Yii::app()->name) ?></div>
        </div>

        <div class="row-fluid" id="center" style="min-width: 50%; max-width:80%; margin: 5% auto">
            <div class="span12" id="content">
                <?= $content ?>
            </div>
        </div>
    </div>

    <div id="footer">
        <hr/>
        Copyright &copy; 2013 - <?= date('Y') ?>
        by <?= CHtml::mailto('Dmitry Soloviyev', 'dmitry.soloviyev@gmail.com') ?>.<br/>
        г. Москва. All Rights Reserved.<br/>
        <?= Yii::powered() ?>
    </div>
</div>
</body>
</html>
