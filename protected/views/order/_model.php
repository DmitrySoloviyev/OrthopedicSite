<?php
$this->widget('ext.fancybox.EFancyBox', [
    'target' => '#picture_resource',
    'config' => [
        'enableEscapeButton' => true,
    ],
]); ?>
<div id="modelContent">

    <div style="font-style: italic; font-size: 1.1em;" id="name">Выберите модель</div>

    <div id="picture">
        <img src=<?= Yii::app()->request->baseUrl ?>"/upload/OrthopedicGallery/ortho.jpg"
             href="<?= Yii::app()->request->baseUrl ?>/upload/OrthopedicGallery/ortho.jpg" id="picture_resource"
             alt='изображение модели'/>
    </div>

    <div id="description"></div>

    <div id="date_created"></div>

    <div id="date_modified"></div>
</div>
