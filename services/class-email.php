<?php

namespace MP\services;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MPEmailService{
    public function getTemplate(string $template_name){
        global $mppluginSetting;

        if(!empty($mppluginSetting->get_setting($template_name . '_mail_subject')) && !empty($mppluginSetting->get_setting($template_name .'_mail_body'))){
            return [
                'mail_subject' => $mppluginSetting->get_setting($template_name .'_mail_subject'),
                'mail_body'    => $mppluginSetting->get_setting($template_name .'_mail_body')
            ];
        }

        return [
            'mail_subject' => '',
            'mail_body'    => $this->getMailText($template_name)
        ];
    }

    public function getMailText(string $template_name){
        ob_start();
        require_once MP_LOCK_CONTENT_PATH . '/email/'.$template_name.'.php';
        return ob_get_clean();
    }

    /**
     * Send Email
     *
     * @param string $to
     * @param string $type
     * @param array $args
     * @return void
     */
    public function send(string $to, string $type, array $args){

        $template   = $this->getTemplate($type);
        $subject    = $template['mail_subject']; // Email subject
        $message    = $template['mail_body'];

        foreach($args as $key => $value){
            $message = preg_replace('/!!'.$key.'!!/', $value, $message);
        }
   
        $headers    = array( 'Content-Type: text/html; charset=UTF-8' );
        return wp_mail( $to, $subject, $message, $headers );

    }

}