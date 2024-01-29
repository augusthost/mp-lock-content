<?php

namespace MP\hooks;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class MPSignupAjax
{    
    protected $email;
    protected $password;

    public function __construct()
    {
        add_action('wp_ajax_signup', [ $this, 'signup_callback']);
        add_action('wp_ajax_nopriv_signup', [ $this, 'signup_callback']);
    }

    protected function sendVerificationEmail($user_id){

        // Get the user's data
        $verification_code = wp_generate_password(20, false);

        update_user_meta($user_id, 'verification_code', $verification_code);

        $to        = $this->email;
        $subject   = 'Email Verification';
        $message   = 'Welcome to '.get_bloginfo('name') . '.<br /><br />';
        $message   .= 'Please click on the following link to verify your email: <br />';
        $message  .= '<a href="' . home_url() . '?verify_code=' . $verification_code . '">Verify Email</a><br /><br />';
        $message  .= 'Best Regards,<br />';
        $message  .= get_bloginfo('name');
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        wp_mail($to, $subject, $message, $headers);

    }

    public function signup_callback()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'mp_signup_nonce')) {
            wp_send_json_error('Invalid nonce');
        }
    
        $this->email    = sanitize_email($_POST['log']);
        $this->password = sanitize_text_field($_POST['pwd']);
    
        if (!is_email($this->email)) {
            wp_send_json_error(['message'=>'Invalid email address']);
        }
    
        if (strlen($this->password) < 6) {
            wp_send_json_error(['message'=>'Password must be at least 6 characters long']);
        }

        $username = sanitize_user(current(explode('@', $this->email)));

        // Check if the username already exists
        if (username_exists($username)) {
            // If the username exists, append a number to make it unique
            $i = 1;
            while (username_exists($username . $i)) {
                $i++;
            }
            $username .= $i;
        }

        $user = wp_create_user($username, $this->password, $this->email);
    
        if (is_wp_error($user)) {
            $error_message = $user->errors['existing_user_login'] ? $user->errors['existing_user_login'][0] : 'Error occure while signing up your account.';
            wp_send_json_error(['message' => $error_message]);
        }
        
        // Lock user by default
        update_user_meta($user, '_is_disabled', 1);
        
        $this->sendVerificationEmail($user);

        wp_send_json_success([ 'message' => 'Successfully registered. Please check your email for verify your email address.']);
    }
}

if(!class_exists('MPSignupAjax')){
    new MPSignupAjax();
}
