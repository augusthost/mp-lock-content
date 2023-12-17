<?php

namespace MP\inc;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MPResetPasswrodAjax
{
    protected $emailData;
    public function __construct()
    {
        add_action('wp_ajax_resetpassword', [$this, 'resetpassword_callback']);
        add_action('wp_ajax_nopriv_resetpassword', [$this, 'resetpassword_callback']);
    }

    public function resetpassword_callback()
    {
        $key = sanitize_text_field( $_POST['key'] );
        $login = sanitize_text_field( $_POST['login'] );
        $password = sanitize_text_field( $_POST['password'] );

        // Check if the reset key is valid
        $user = get_user_by( 'login', $login );
        if ( ! $user ) {
            wp_send_json_error( 'Invalid user' );
        }

        // Check the validity of reset key
        $expected_key = get_user_meta( $user->ID, 'password_reset_key', true );

        if ( $key !== $expected_key ) {
            wp_send_json_error( ['message' => 'Invalid reset key'] );
        }

        // Reset the user's password
        wp_set_password( $password, $user->ID );

        // Clear the password reset key
        delete_user_meta( $user->ID, 'password_reset_key' );

        wp_send_json_success( 'Password reset successfully' );
    }

}

if(!class_exists('MPResetPasswrodAjax')){
    new MPResetPasswrodAjax();
}
