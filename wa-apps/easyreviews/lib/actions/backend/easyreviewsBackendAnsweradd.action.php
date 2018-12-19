<?php

class easyreviewsBackendAnsweraddAction extends waViewAction
{
    public function execute()
    {
        $id = waRequest::get('id', 'int');
        $model = new easyreviewsModel();
        $model_answers = new easyreviewsAnswersModel();
        $emails_model = new waContactEmailsModel();

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
                $name = $this->getUser()->getName();
                $contact_id = $this->getUser()->getId();
                $contacts = $emails_model->getByField('contact_id', $contact_id );
                $email = $contacts['email'];

                $model_answers->insert(array(
                  'review_id' => $id,
                  'name' => htmlspecialchars($name),
                  'body' => $body,
                  'moderated' => 1,
                  'email' => $email,
                  'contact_id' => $contact_id,
                  'datetime' => $datetime
                ));

                $model->updateById($id, array('answer' => 1));

                $this->redirect(wa()->getAppUrl());
            }

            $this->view->assign('errors', $errors);
        }

        $this->setLayout(new easyreviewsBackendLayout());
    }
}
