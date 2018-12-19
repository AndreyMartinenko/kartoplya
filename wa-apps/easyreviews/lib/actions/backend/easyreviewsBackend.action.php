<?php

class easyreviewsBackendAction extends waViewAction
{
    public function execute()
    {
        $model = new easyreviewsModel();
        $records = $model->order('id DESC')->fetchAll();
        $this->view->assign('records', $records);

        $model_answers = new easyreviewsAnswersModel();
        $answers = $model_answers->order('id DESC')->fetchAll();
        $this->view->assign('answers', $answers);

        $contact_model = new waContactModel();
        $contacts = $contact_model->order('id')->fetchAll();
        $this->view->assign('contacts', $contacts);

        $setting_model = new waContactSettingsModel();
        $app = 'easyreviews';

        $user = waSystem::getInstance()->getUser();
        $user_id = $user->getId();
        $count =  count($records);

        $setting_model->set($user_id, $app, 'count', $count);
        wa()->getConfig()->setCount(0);

        wa('site');
        $domain_array = siteHelper::getDomains(true);
        $current_domain_name = siteHelper::getDomain();
        if( !wa()->getRouting()->getByApp('easyreviews' , $current_domain_name ) ) $settings['routing_exist'] = 0;
        else $settings['routing_exist'] = 1;
        $this->view->assign('settings', $settings);

        $this->setLayout(new easyreviewsBackendLayout());
    }
}
