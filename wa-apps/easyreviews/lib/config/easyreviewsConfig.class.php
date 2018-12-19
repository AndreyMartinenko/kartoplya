<?php

class easyreviewsConfig extends waAppConfig
{
    public function onCount()
    {
        $model = new easyreviewsModel();
        $records = $model->order('datetime DESC')->fetchAll();
        $setting_model = new waContactSettingsModel();
        $app = 'easyreviews';

        $user = waSystem::getInstance()->getUser();
        $user_id = $user->getId();
        $count =  count($records);

        return $count - $user->getSettings($app, 'count');
    }
    public function getAllSettings()
    {
        $settings = array(
            'show_captcha' => true,
            'auth_only' => true,
            'avatar' => true,
            'gravatar' => true,
            'lazyloading' => false,
            'pagination' => 10,
            'send_email' => false,
            'require_email' => false,
            'recipient' => null,
            'validation' => false,
            'google_captcha' => false,
            'site_key' => null,
            'secret_key' => null,
            'ajax' => true,
        );

        foreach($settings as $k => $def) {
            $settings[$k] = wa()->getSetting($k, $def);
        }

        return $settings;
    }
}
