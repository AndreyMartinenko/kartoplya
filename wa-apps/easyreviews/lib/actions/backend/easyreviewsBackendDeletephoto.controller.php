<?php

class easyreviewsBackendDeletephotoController extends waController
{
    public function execute()
    {
        $id = waRequest::get('id', 'int');
        
        if ($id) {
            $model = new easyreviewsModel();
            $model->updateById($id, array('photo' => ''));
            waFiles::delete(wa()->getDataPath(''.$id.'/', true)); 
        }

        $this->redirect(wa()->getAppUrl());
    }
}