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
                var regexp = new RegExp(query, 'gim');

                if (query != '') {
                    searchResults.html(
                        text.replace(regexp, '<span class=\"highlight\">$&</span>')
                    );
                }
            ", CClientScript::POS_END);
            $result->model->showSearchResults();
            echo '<br>';
            $this->widget('zii.widgets.CListView', [
                'dataProvider' => $result,
                'itemView' => '/' . $result->model->viewDir() . '/_search_result',
                'summaryText' => false,
                'emptyText' => false,
                'template' => '{items}',
            ]);
        }
    } ?>
</div>
