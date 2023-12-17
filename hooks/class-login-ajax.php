<?php

namespace MP\hooks;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class MPLoginAjax
{
    public function __construct()
    {
        add_action('wp_ajax_login', [ $this, 'login_callback']);
        add_action('wp_ajax_nopriv_login', [ $this, 'login_callback']);
    }

    public function login_callback()
    {

        // Remove all action related to wp_login_failed
        remove_all_actions( 'wp_login_failed' );

        $user_login  = sanitize_text_field($_POST['log']);
        $user_pass   = sanitize_text_field($_POST['pwd']);
        $rememberme  = isset($_POST['rememberme']) ? sanitize_text_field($_POST['rememberme']) : false;
        $redirect_to = isset($_POST['redirect_to']) ? sanitize_text_field($_POST['redirect_to']) : '';
        
        $user = wp_signon(
            [
                'user_login'    => $user_login,
                'user_password' => $user_pass,
                'remember'      => $rememberme,
            ],
            false
        );


        if (is_wp_error($user)) {
            $error_code = $user->get_error_code();
            wp_send_json_error([ 'code' => $error_code, 'message' => $user->get_error_message() ]);
        }

        if (!is_wp_error($user)) {
            wp_set_current_user($user->ID, $user_login);
            wp_set_auth_cookie($user->ID, $rememberme);
            do_action('wp_login', $user_login, $user);
            wp_send_json_success([ 'redirect_to' => $redirect_to ]);
        }
    }
}

if(!class_exists('MPLoginAjax')){
    new MPLoginAjax();
}
