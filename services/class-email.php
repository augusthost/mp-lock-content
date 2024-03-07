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

    /**
     * Get Email template text
     *
     * @param string $template_name
     * @return void
     */
    public function getMailText(string $template_name){
        ob_start();
        require_once MP_LOCK_CONTENT_PATH . '/email/'.$template_name.'.php';
        return ob_get_clean();
    }

    /**
     * Get Global Keywords
     *
     * @param string $receiver
     * @return array
     */
    private function getGlobalKeywords(string $email): array{
        $user = get_user_by('email', $email);
        $user = get_userdata($user->ID);
        return [
            'email'            => $user->user_email,
            'username'         => $user->user_login,
            'first_name'       => $user->first_name,
            'last_name'        => $user->last_name,
            'phone'            => $user->phone,
            'organization'     => $user->organization,
            'site_name'        => get_bloginfo('title'),
            'web_url'          => site_url(),
            'login_link'       => site_url('/login'),
            'site_description' => get_bloginfo('description')
        ];
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

        $globalkeywords  = $this->getGlobalKeywords($to);
        $keywords        = array_merge($globalkeywords,$args);

        $template        = $this->getTemplate($type);
        $subject         = $template['mail_subject']; // Email subject
        $message         = $template['mail_body'];

        foreach($keywords as $key => $value){
            $message = preg_replace('/!!'.$key.'!!/', $value, $message);
        }
   
        $headers    = array( 'Content-Type: text/html; charset=UTF-8' );
        return wp_mail( $to, $subject, $message, $headers );

    }

}