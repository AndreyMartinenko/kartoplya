<?php

class easyreviewsFrontendActions extends waJsonActions
{
  function defaultAction()
  {

  }

  function ajaxAction()
  {
    $model = new easyreviewsModel();
    $model_answers = new easyreviewsAnswersModel();
    $emails_model = new waContactEmailsModel();
    $contacts_model = new waContactModel();
    $settings = wa()->getConfig()->getAllSettings();
    $success = 0;
    if (waRequest::method() == 'post') {

      $errors = array(
        'name' => '1',
        'email' => '1',
        'body' => '1',
        'captcha' => '1',
      );

      $url = waRequest::post('url');

      if ($settings['auth_only'] == 1) {
        if ($this->getUser()) {
          $contact_id = $this->getUser()->getId();
          $name = $this->getUser()->getName();
          $contacts = $emails_model->getByField('contact_id', $contact_id );
          $email = $contacts['email'];
          unset($errors['name']);
          unset($errors['email']);
        }
      } else {
        if ($this->getUser()->getId() != 0) {
          $contact_id = $this->getUser()->getId();
          $name = $this->getUser()->getName();
          $contacts = $emails_model->getByField('contact_id', $contact_id );
          $email = $contacts['email'];
          unset($errors['name']);
          unset($errors['email']);
        } else {
          if ($name = waRequest::post('name')) {
            $contact_id = waRequest::post('contact_id');
            unset($errors['name']);
            if ($settings['require_email'] == 1) {
              $email = waRequest::post('email');
              $valid_email = new waEmailValidator();
              if ($valid_email->isValid($email)) {
                unset($errors['email']);
              }
            } else {
              unset($errors['email']);
              $email = '';
            }
          }
        }
      }

      if ($body = waRequest::post('body')) {
        unset($errors['body']);
      }

      if ($settings['show_captcha'] == 1) {
        if ($settings['google_captcha'] != 1) {
          if (wa()->getCaptcha()->isValid()) {
            unset($errors['captcha']);
          }
        } else {
          $app_config = wa()->getConfig()->getAppConfig('easyreviews');

          // recaptcha 2.0
          /*require_once($app_config->getAppPath('recaptcha').'/autoload.php');
          $recaptcha = new \ReCaptcha\ReCaptcha($settings['secret_key']);
          $resp = $recaptcha->verify(waRequest::post('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
          if ($resp->isSuccess()) {
          unset($errors['captcha']);
        }*/

        require_once($app_config->getAppPath('recaptcha').'/recaptchalib.php');
        $secret = $settings['secret_key'];
        $lang = "ru";
        $resp = null;
        $error = null;
        $reCaptcha = new ReCaptcha($secret);
        if (waRequest::post('g-recaptcha-response')) {
          $resp = $reCaptcha->verifyResponse(
          $_SERVER["REMOTE_ADDR"],
          waRequest::post('g-recaptcha-response')
        );
      }

      if ($resp != null && $resp->success) {
        unset($errors['captcha']);
      }


    }
  } else {
    unset($errors['captcha']);
  }

  if ($settings['validation'] == 1) {
    $moderated = 0;
  } else {$moderated = 1;}
  
  $phone = waRequest::post('phone');
  
  /*print_r($phone);
  exit();*/

  if (empty($errors)) {
    $success = 1;
    $model->insert(array(
      'name' => htmlspecialchars($name),
      'body' => $body,
      'moderated' => $moderated,
      'email' => $email,
      'photo' => $phone,
      'defaultphoto' => 0,
      'contact_id' => $contact_id,
      'datetime' => date('Y-m-d H:i')
    ));

    if ($settings['send_email'] == 1) {

      $url = (waRequest::server('HTTPS') ? 'https' : 'http').'://'.waRequest::server('HTTP_HOST').waRequest::server('REQUEST_URI');
      $text = _w('New review added to page').' '.$url."\n\n";
      $text .= "\n";
      $text .= _w('Name').": ".htmlspecialchars($name);
      $text .= "\n";
      $text .= _w('Text').": ".htmlspecialchars($body);

      try {
        $m = new waMailMessage();
        $m->setTo($settings['recipient']);
        $m->setBody(nl2br($text));
        $m->setSubject(_w('New review added'));
        @$m->send();
      } catch (Exception $e) {
        waLog::log('feedback: unable to send email to '.$settings['recipient'].': '.$e->getMessage());
      }
    }



  } else {$success = 0;}

  $this->response = array(
    'success' => $success,
    'errors' => $errors,
  );

}

}

}
