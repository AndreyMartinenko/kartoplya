<?php

class easyreviewsBackendAddAction extends waViewAction
{
    public function execute()
    {
        ini_set("display_errors", 1);
		    error_reporting(E_ALL);
        $session = waRequest::cookie('PHPSESSID');
        $this->view->assign('session', $session);

        $model = new easyreviewsModel();
        $emails_model = new waContactEmailsModel();

        $currentdate = date('Y-m-d H:i');
        $this->view->assign('currentdate', $currentdate);

        if (waRequest::method() == 'post') {

            $errors = array(
                'name' => '1',
                'body' => '1',
                'datetime' => '1'
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
            } else {$email = '';}

            $defaultphoto = waRequest::post('defaultphoto');

            if (empty($errors)) {

                $contact_id = wa()->getUser()->getId();
                $contacts = $emails_model->getByField('contact_id', $contact_id );

                $result = $model->insert(array(
                  'name' => htmlspecialchars($name),
                  'body' => $body,
                  'moderated' => 1,
                  'email' => $email,
                  'contact_id' => $contact_id,
                  'defaultphoto' => $defaultphoto,
                  'photo' => '0',
                  'datetime' => $datetime
                ));

                if ($file_name = waRequest::post('file_name')) {
                    $id = $result;

                    $path = wa()->getDataPath(''.$id.'/', true);
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
