<?php

namespace MP\services;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MPEmailService{
    public function getTemplate(string $template_name){
        global $mppluginSetting;

        if(!empty($mppluginSetting->get_setting('mail_subject')) && !empty($mppluginSetting->get_setting('mail_body'))){
            return [
                'mail_subject' => $mppluginSetting->get_setting('mail_subject'),
                'mail_body'    => $mppluginSetting->get_setting('mail_body')
            ];
        }

        return [
            'mail_subject' => 'Welcome to MPE&VCA',
            'mail_body'    => $this->getMailText($template_name)
        ];
    }

    public function getMailText(string $template_name){
        ob_start();
        require_once MP_LOCK_CONTENT_PATH . '/email/'.$template_name.'.php';
        return ob_get_clean();
    }

}