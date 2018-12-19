<?php

class easyreviewsBackendAnswereditAction extends waViewAction
{
    public function execute()
    {
        $id = waRequest::get('id', 'int');
        $model = new easyreviewsAnswersModel();

        if ($id) {
            $records = $model->getById($id);
            $this->view->assign('records', $records);
        }

        if (waRequest::method() == 'post') {

            $errors = array(
                'body' => '1',
                'datetime' => '1'
            );

            if ($body = waRequest::post('body')) {
                unset($errors['body']);
            }

            $datetime = waRequest::post('datetime');

            if (strtotime($datetime)) {
                unset($errors['datetime']);
            }

            if (empty($errors)) {
                $model->updateById($id, array('body' => $body, 'datetime' => $datetime));
                $this->redirect(wa()->getAppUrl());
            }

            $this->view->assign('errors', $errors);
        }

        $this->setLayout(new easyreviewsBackendLayout());
    }
}
