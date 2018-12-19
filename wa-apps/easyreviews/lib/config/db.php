<?php
return array(
    'easyreviews' => array(
        'id' => array('int', 11, 'null' => 0, 'autoincrement' => 1),
        'contact_id' => array('int', 11, 'null' => 0, 'default' => '0'),
        'name' => array('varchar', 255, 'null' => 0, 'default' => ''),
        'body' => array('text', 'null' => 0),
        'email' => array('varchar', 255),
        'photo' => array('text', 'null' => 0),
        'answer' => array('int', 11, 'null' => 0, 'default' => '0'),
        'moderated' => array('int', 11, 'null' => 0, 'default' => '1'),
        'defaultphoto' => array('int', 11, 'null' => 0, 'default' => '0'),
        'datetime' => array('datetime', 'null' => 0),
        ':keys' => array(
            'PRIMARY' => 'id',
            'datetime' => 'datetime',
        ),
    ),
    'easyreviews_answers' => array(
        'id' => array('int', 11, 'null' => 0, 'autoincrement' => 1),
        'review_id' => array('int', 11, 'null' => 0),
        'contact_id' => array('int', 11, 'null' => 0, 'default' => '0'),
        'name' => array('varchar', 255, 'null' => 0, 'default' => ''),
        'body' => array('text', 'null' => 0),
        'email' => array('varchar', 255),
        'datetime' => array('datetime', 'null' => 0),
        ':keys' => array(
            'PRIMARY' => 'id',
            'datetime' => 'datetime',
        ),
    ),
);
