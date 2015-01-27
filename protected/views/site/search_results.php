<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 11.01.15
 * Time: 18:32
 */
?>

    Результаты поиска по запросу <b><?= $query ?> </b><br><br>

<?php
if ($results) {
    print_r($results);
    foreach ($results as $result) {
//        $result->showSearchResults();
        $result->getData();
    }
} else {
    echo 'Ничего не найдено';
}

