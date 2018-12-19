<?php

class easyreviewsBackendValidationController extends waController
{
    public function execute()
    {
      $id = waRequest::get('id', 'int');
        if ($id) {
          $model = new easyreviewsModel();
          $records = $model->getById($id);
            
          if ($records['moderated'] == 0) {
            $model->updateById($id, array('moderated' => '1'));
          } else {
            $model->updateById($id, array('moderated' => '0'));
          }
        }
      $this->redirect(wa()->getAppUrl());
    }
}