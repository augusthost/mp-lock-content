<?php

add_shortcode( 'mp-signup-form', 'myprefix_signup_form_shortcode' );

function myprefix_signup_form_shortcode() {
    ob_start();
    require_once( MP_LOCK_CONTENT_PATH . '/view/auth/signup.php' );
    return ob_get_clean();
}
