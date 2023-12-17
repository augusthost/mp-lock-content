<?php

add_shortcode( 'mp-login-form', 'myprefix_login_form_shortcode' );

function myprefix_login_form_shortcode() {
    if(is_user_logged_in()){
        echo 'You\'re already logged in.';
        return;
    }

    $is_forgot_pass = isset($_GET['action']) && $_GET['action'] === 'forgot_pass';
    $is_reset_pass  = isset($_GET['key']) && $_GET['login'] && gettype($_GET['key']) === 'string' && gettype($_GET['login']) === 'string'; 

    ob_start();

    if($is_reset_pass){
        require_once( MP_LOCK_CONTENT_PATH . '/view/auth/reset-pass.php' );
        return ob_get_clean();
    }

    if($is_forgot_pass){
        require_once( MP_LOCK_CONTENT_PATH . '/view/auth/forgot-pass.php' );
        return ob_get_clean();
    }

    require_once( MP_LOCK_CONTENT_PATH . '/view/auth/login.php' );
    return ob_get_clean();
}
