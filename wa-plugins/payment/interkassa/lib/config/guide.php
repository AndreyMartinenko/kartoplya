<?php

return array(
    array(
        'value'       => '%RELAY_URL%',
        'title'       => 'URL взаимодействия',
        'description' => 'Адрес отправки оповещения о платеже. <strong>Скопируйте и сохраните указанный в этом поле адрес в соответствующем поле внутри вашего аккаунта на сайте платежной системы.</strong>',
    ),
    array(
        'value'       => '%RELAY_URL%?result=success',
        'title'       => 'URL успешной оплаты',
        'description' => 'Адрес страницы с уведомлением об успешно проведенном платеже. <strong>Скопируйте и сохраните указанный в этом поле адрес в соответствующем поле внутри вашего аккаунта на сайте платежной системы.</strong>',
    ),
    array(
        'value'       => '%RELAY_URL%?result=success',
        'title'       => 'URL ожидания проведения платежа',
        'description' => 'Адрес страницы с уведомлением об успешно проведенном платеже. <strong>Скопируйте и сохраните указанный в этом поле адрес в соответствующем поле внутри вашего аккаунта на сайте платежной системы.</strong>',
    ),
    array(
        'value'       => '%RELAY_URL%?result=fail',
        'title'       => 'URL неуспешной оплаты',
        'description' => 'Адрес страницы с уведомлением о неудавшемся платеже. <strong>Скопируйте и сохраните указанный в этом поле адрес в соответствующем поле внутри вашего аккаунта на сайте платежной системы.</strong>',
    ),
);
