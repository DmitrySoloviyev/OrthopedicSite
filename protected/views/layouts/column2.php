<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="span10">
        <div id="content">
            <?= $content; ?>
        </div>
    </div>
    <div class="span2">
        <div id="sidebar">
            <?php
            $this->beginWidget('zii.widgets.CPortlet', [
                'title' => 'Operations',
            ]);
            $this->widget('zii.widgets.CMenu', [
                'items' => $this->menu,
                'htmlOptions' => ['class' => 'operations'],
            ]);
            $this->endWidget();
            ?>
        </div>
    </div>
<?php $this->endContent(); ?>
