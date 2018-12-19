<?php

class siteYandexPlugin extends sitePlugin {


    public function backendSidebar()
    {
        $lang = array(
            'yandex' => 'Яндекс.Карты'
        );

        $output = <<<HTML
<li id="s-link-search"><a href="#/yandex/"><i class="icon16 search"></i>{$lang['yandex']}</a>
<script>
$(function(){
    $.wa.site.searchAction = function() {
        $("#s-content").load('?plugin=yandex', function(){
            $.wa.site.active($("#s-link-search"));
        });
    }
});
</script>
</li>
HTML;
        return array(
            'menu_li' => $output,
        );
    }
}