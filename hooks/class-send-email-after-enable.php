<?php

namespace MP\hooks;

use MP\services\MPEmailService;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MPSendEmailAfterEnable{
    public function __construct()
    {
        if (!defined('SS_DISABLE_USER_LOGIN_FILE')) return;
        add_action('disable_user_login.user_enabled',[$this, 'mp_send_email_to_user'],90,1);
    }

    public function mp_send_email_to_user($user_id) {

        $user     = get_userdata($user_id); // Get user data
        $username = $user->user_login; // Get the username
        $to       = $user->user_email; // Email recipient
        
        // Check if the email has already been sent
        $email_sent = get_user_meta($user_id, 'send_user_approved_email', true);
        if ($email_sent == '1') {
            return; // Email already sent, so exit the function
        }

        $args = [
            'username' => $username,
            'login_link' => home_url('/login')
        ];
        
        (new MPEmailService())->send($to,'welcome', $args);
        
        // Update user meta to indicate that the email has been sent
        update_user_meta($user_id, 'send_user_approved_email', '1');
    }
}

if(!class_exists('MPSendEmailAfterEnable')){
    new MPSendEmailAfterEnable();
}