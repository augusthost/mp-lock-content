<?php

namespace MP\hooks;

class MPSendEmailAfterEnable{
    public function __construct()
    {
        if (!defined('SS_DISABLE_USER_LOGIN_FILE')) return;
        add_action('disable_user_login.user_disabled',[$this, 'mp_send_email_to_user'],10,1);
    }

    public function mp_send_email_to_user($user_id) {
        $user = get_userdata($user_id); // Get user data
        $username = $user->user_login; // Get the username
        
        $to = $user->user_email; // Email recipient
        $subject = 'Welcome to MPE&VCA'; // Email subject
        
        // Check if the email has already been sent
        $email_sent = get_user_meta($user_id, 'send_user_approved_email', true);
        if ($email_sent == '1') {
            return; // Email already sent, so exit the function
        }
        
        // Email message
        $message = "Dear $username,\n\n";
        $message .= "Thank you for your interest in MPE&VCA. You now have access to news and information exclusive to our valued members. To start reading, please confirm this email address by clicking the button below.\n\n";
        $message .= "Log In\n\n";
        $message .= "I hope you enjoy our news and resources. Please reach out to info@mpevca.org with any questions or concerns.\n\n";
        $message .= "Sincerely,\nMPE&VCA";
        
        $headers[] = 'Content-Type: text/plain; charset=UTF-8'; // Set email content type
        
        // Send the email
        wp_mail($to, $subject, $message, $headers);
        
        // Update user meta to indicate that the email has been sent
        update_user_meta($user_id, 'send_user_approved_email', '1');
    }
}

if(!class_exists('MPSendEmailAfterEnable')){
    new MPSendEmailAfterEnable();
}