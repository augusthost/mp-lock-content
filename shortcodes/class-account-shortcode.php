<?php

add_shortcode( 'mp-account', 'myprefix_account_shortcode' );

function myprefix_account_shortcode() {
    if(!is_user_logged_in()){
        wp_safe_redirect(home_url());
        return;
    }
    ob_start();

    require_once( MP_LOCK_CONTENT_PATH . '/view/account.php' );


    return ob_get_clean();
}
