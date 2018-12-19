<?php

class easyreviewsBackendDeleteController extends waController
{
    public function execute()
    {
        $id = waRequest::get('id', 'int');
        
        if ($id) {
            $model = new easyreviewsModel();
            $model->deleteById($id);
            waFiles::delete(wa()->getDataPath(''.$id.'/', true)); 
        }

        $this->redirect(wa()->getAppUrl());
    }
}