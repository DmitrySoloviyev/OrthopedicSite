<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 11.01.15
 * Time: 18:32
 */
?>

<p>Результаты поиска по запросу <b id="query"><?= CHtml::encode($query) ?></b>:</p>
<div id="searchResults">
    <?php foreach ($results as $result) {
        if ($result) {
            Yii::app()->clientScript->registerScript('keywords', "
                var query = $('#query').text();
                var searchResults = $('#searchResults');
                var text = searchResults.html();
                var regexp = new RegExp('('+query+')(?!.*\">)', 'gim');

                if (query != '') {
                    searchResults.html(
                        text.replace(regexp, '<span class=\"highlight\">$1</span>')
                    );
                }
            ", CClientScript::POS_END);
            echo '<b class="label_title">' . $result->model->showSearchResults() . '</b>';
            $this->widget('bootstrap.widgets.TbListView', [
                'dataProvider' => $result,
                'itemView' => '/' . $result->model->viewDir() . '/_search_result',
                'emptyText' => '<span style="padding-left: 20px">Ничего не найдено :(</span>',
                'template' => '{items}',
            ]);
        }
    } ?>
</div>
