<?php

$mod = new waModel();
$model = new easyreviewsModel();

try {
    $model->query('SELECT photo FROM easyreviews WHERE 0');

} catch (waDbException $e) {
    $sql = 'ALTER TABLE easyreviews ADD photo text NOT NULL';
    $model->exec($sql);
}