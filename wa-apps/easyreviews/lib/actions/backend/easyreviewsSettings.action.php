<?php

class easyreviewsSettingsAction extends waViewAction
{
    public function execute()
    {
        $settings = wa()->getConfig()->getAllSettings();

        $errors = array();
        if ( ( $from_post = waRequest::post('settings')) && is_array($from_post)) {

            $settings['show_captcha'] = !empty($from_post['show_captcha']);
            $settings['auth_only'] = !empty($from_post['auth_only']);
            $settings['avatar'] = !empty($from_post['avatar']);
            $settings['gravatar'] = !empty($from_post['gravatar']);
            $settings['lazyloading'] = !empty($from_post['lazyloading']);
            $settings['pagination'] = ifempty($from_post['pagination']);
            $settings['send_email'] = !empty($from_post['send_email']);
            $settings['validation'] = !empty($from_post['validation']);
            $settings['require_email'] = !empty($from_post['require_email']);
            $settings['google_captcha'] =  !empty($from_post['google_captcha']);
            $settings['ajax'] =  !empty($from_post['ajax']);
            $take_email = ifempty($from_post['recipient']);


            if ($take_email != '') {
                $settings['recipient'] = $take_email;
            }

            if ($settings['google_captcha'] == 1) {
                $settings['site_key'] =  htmlentities(ifempty($from_post['site_key']));
                $settings['secret_key'] =  htmlentities(ifempty($from_post['secret_key']));
            }

            if ($settings['send_email'] == 1) {
                if (strlen($settings['recipient'])) {
                    $email = new waEmailValidator();
                    if (!$email->isValid($settings['recipient'])) {
                        $errors['recipient'] = '1';
                    }
                }
            }

            if (strlen($settings['pagination'])) {

              $number = new waNumberValidator();

              if (!$number->isValid($settings['pagination'])) {
                $errors['pagination'] = '1';
              }

            }

            if (!$errors) {
                $asm = new waAppSettingsModel();
                foreach($settings as $k => $v) {
                    $asm->set('easyreviews', $k, $v);
                }
            }
        }

        $this->view->assign('settings', $settings);
        $this->view->assign('errors', $errors);

        $this->setLayout(new easyreviewsBackendLayout());
    }
}
