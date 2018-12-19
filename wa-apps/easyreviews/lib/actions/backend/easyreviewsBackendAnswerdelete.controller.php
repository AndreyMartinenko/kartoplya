<?php

class easyreviewsBackendAnswerdeleteController extends waController
{
    public function execute()
    {
        $id = waRequest::get('id', 'int');
        if ($id) {
          $model = new easyreviewsModel();
          $records = $model->getById($id);
          $model->updateById($id, array('answer' => '0'));    
        }
        
        $answerid = waRequest::get('answerid', 'int');
        
        if ($answerid) {
            $model = new easyreviewsAnswersModel();
            $model->deleteById($answerid);
        }

        $this->redirect(wa()->getAppUrl());
    }
}