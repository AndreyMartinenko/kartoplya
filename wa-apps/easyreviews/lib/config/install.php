<?php

//create block with last reviews at install
try {
    $model = new easyreviewsBlockModel();
    $blockname = 'easyreviews.last_reviews';
    $blockdesc = _w('Latest reviews');
    $blockcontent = '
{literal}
<style>
.easyreviews .wa-error {border: 2px solid red;}
.easyreviews .name {font-size: 14pt; font-weight: bold;}
.easyreviews .datetime {padding-left: 10px; color: #aaa;}
.easyreviews .avatar-block {
    float: left;
    display: block;
    padding-bottom: 20px;
    padding-right: 10px;
}
.easyreviews .avatar {border-radius: 50%;}
.review-body {padding-top: 10px;}
</style>
{/literal}
<div class="easyreviews">
  {foreach from=$wa->easyreviews->last(3) item=r}
    <div class="post">
        <div class="avatar-block">
          {if $r.contact_id == 0}
            <img class="avatar" src="/wa-content/img/userpic96.jpg" />
          {else}
            <img class="avatar" src="{$r.photo_url}">
          {/if}
          </div>
        <div class="review-body">
          <p><span class="name">{$r.name|escape}</span><span class="datetime">{$r.datetime|wa_date:"humandatetime"}</span></p>
          <p>{$r.body|escape|nl2br}</p>
        </div>
    </div>
    <div class="clear-both"></div>
  {/foreach}
</div>';
    
    $model->insert(array(
        'id' => $blockname,
        'content' => $blockcontent,
        'create_datetime' => waDateTime::format('date'),
        'description' => $blockdesc
    ));
} catch(Exception $e) {
    waLog::log($e->getMessage());
}