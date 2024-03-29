<?php

namespace MP\hooks;

use MP\services\MPEmailService;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class MPSignupAjax
{    
    protected $email;
    protected $password;
    protected $organization;
    protected $phone;
    protected $first_name;
    protected $last_name;

    public function __construct()
    {
        add_action('wp_ajax_signup', [ $this, 'signup_callback']);
        add_action('wp_ajax_nopriv_signup', [ $this, 'signup_callback']);
    }

    protected function sendVerificationEmail($user_id){

        // Get the user's data
        $verification_code = wp_generate_password(20, false);

        update_user_meta($user_id, 'verification_code', $verification_code);

        $verification_link = home_url() . '?verify_code=' . $verification_code;
        $args = [
            'site_name' => get_bloginfo('name'),
            'verification_link' => $verification_link
        ];
        
        (new MPEmailService())->send($this->email,'verification', $args);

    }

    public function signup_callback()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'mp_signup_nonce')) {
            wp_send_json_error('Invalid nonce');
        }
    
        $this->email        = sanitize_email($_POST['log']);
        $this->password     = sanitize_text_field($_POST['pwd']);
        $this->organization = sanitize_text_field($_POST['organization']);
        $this->phone        = sanitize_text_field($_POST['phone']);
        $this->first_name   = sanitize_text_field($_POST['first_name']);
        $this->last_name    = sanitize_text_field($_POST['last_name']);

        if(empty($this->email)){
            wp_send_json_error(['message'=>'Email is required']);
        }

        if(empty($this->organization)){
            wp_send_json_error(['message'=>'Organization is required']);
        }

        if(empty($this->first_name)){
            wp_send_json_error(['message'=>'First Name is required']);
        }

        if(empty($this->last_name)){
            wp_send_json_error(['message'=>'Last Name is required']);
        }

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
        // Update user metas
        update_user_meta($user, 'organization', $this->organization);
        update_user_meta($user, 'phone', $this->phone);
        update_user_meta($user, 'first_name', $this->first_name);
        update_user_meta($user, 'last_name', $this->last_name);
        
        $this->sendVerificationEmail($user);

        wp_send_json_success([ 'message' => 'Successfully registered. Please check your email to verify your email address.']);
    }
}

if(!class_exists('MPSignupAjax')){
    new MPSignupAjax();
}
