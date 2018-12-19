<?php

$mod = new waModel();
$model = new easyreviewsModel();

try {
    $model->query('SELECT defaultphoto FROM easyreviews WHERE 0');

} catch (waDbException $e) {
    $sql = 'ALTER TABLE easyreviews ADD defaultphoto INT(11) NOT NULL';
    $model->exec($sql);
}
