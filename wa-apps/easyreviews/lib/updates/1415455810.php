<?php

$mod = new waModel();
$mod->exec("
    CREATE TABLE IF NOT EXISTS `easyreviews_answers` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `review_id` INT NOT NULL,
        `contact_id` INT NOT NULL,
        `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
        `body` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
        `email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
        `datetime` DATETIME NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE = MYISAM
");

$model = new easyreviewsModel();

//попытка получить содержимое потенциально отсутствующего поля таблицы
try {
    $model->query('SELECT answer FROM easyreviews WHERE 0');

//в случае неудачи — если поле отсутствует — добавляем его в таблицу
} catch (waDbException $e) {
    $sql = 'ALTER TABLE easyreviews ADD answer INT(11) NOT NULL DEFAULT 0';
    $model->exec($sql);
}