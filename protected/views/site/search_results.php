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
    echo $results;
} else {
    echo 'Ничего не найдено';
}

