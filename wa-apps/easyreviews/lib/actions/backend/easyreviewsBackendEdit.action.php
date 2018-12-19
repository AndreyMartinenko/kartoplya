<?php

class easyreviewsBackendEditAction extends waViewAction
{
    public function execute()
    {
        ini_set("display_errors", 1);
		    error_reporting(E_ALL);
        $session = waRequest::cookie('PHPSESSID');
        $this->view->assign('session', $session);

        $id = waRequest::get('id', 'int');
        $model = new easyreviewsModel();

        if ($id) {
            $records = $model->getById($id);
            $this->view->assign('records', $records);
        }

        if (waRequest::method() == 'post') {

            $errors = array(
                'name' => '1',
                'body' => '1',
                'datetime' => '1',
            );

            if ($name = waRequest::post('name')) {
                unset($errors['name']);
            }

            if ($body = waRequest::post('body')) {
                unset($errors['body']);
            }

            $datetime = waRequest::post('datetime');

            if (strtotime($datetime)) {
                unset($errors['datetime']);
            }

            if ($email = waRequest::post('email')) {
                $valid_email = new waEmailValidator();
            } else {$email = "";}

            $defaultphoto = waRequest::post('defaultphoto');

            if (empty($errors)) {
                $model->updateById($id, array('body' => $body, 'name' => htmlspecialchars($name), 'datetime' => $datetime, 'email' => $email, 'defaultphoto' => $defaultphoto));

                $file_name = waRequest::post('file_name');
                if ($file_name) {

                    $photo = $records['photo'];
                    $path = wa()->getDataPath(''.$id.'/', true);
                    waFiles::delete(wa()->getDataPath(''.$id.'/', true)."$photo");
                    waFiles::create($path, true);
                    waFiles::copy(wa()->getDataPath(''.$session.'/', true)."$file_name", wa()->getDataPath(''.$id.'/', true)."$file_name");
                    waFiles::delete(wa()->getDataPath(''.$session.'/', true));

                    $model->updateById($id, array('photo' => $file_name));
                }

                $this->redirect(wa()->getAppUrl());
            }

            $this->view->assign('errors', $errors);
        }

        $this->setLayout(new easyreviewsBackendLayout());
    }
}
