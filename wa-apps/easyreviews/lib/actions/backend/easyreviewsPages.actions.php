<?php
/*
 * Used to show cheat-sheet in design editor.
 */
class easyreviewsPagesActions extends waPageActions
{

    protected $url = '#/pages/';
    protected $add_url = '#/pages/add';

    protected $options = array(
        'codemirror' => false,
        'ace' => true,
        'container' => false,
        'show_url' => true,
        'save_panel' => true,
        'js' => false,
        'is_ajax' => true,
        'data' => array()
    );
}
