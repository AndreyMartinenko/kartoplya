<?php

class easyreviewsBackendLayout extends waLayout
{
    public function execute()
    {
      $model = new easyreviewsModel();
      $count = $model->query('SELECT * FROM easyreviews')->count();
      $this->view->assign('count', $count);
    }
}
