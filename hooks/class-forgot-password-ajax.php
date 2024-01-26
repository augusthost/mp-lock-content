<?php

namespace MP\hooks;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MPForgotPasswrodAjax
{
    protected $emailData;
    public function __construct()
    {
        add_action('wp_ajax_lostpassword', [$this, 'lostpassword_callback']);
        add_action('wp_ajax_nopriv_lostpassword', [$this, 'lostpassword_callback']);
    }

    // public function log_wp_mail_errors( $wp_error ) {
    //     error_log( 'WP Mail Error: ' . $wp_error->get_error_message() );
    // }
    

    public function lostpassword_callback()
    {
        $user_login = sanitize_text_field( $_POST['user_login'] );

        // Check if the submitted username or email exists
        $user_data = get_user_by( 'login', $user_login );
        if ( ! $user_data ) {
            $user_data = get_user_by( 'email', $user_login );
        }

        if ( ! $user_data ) {
            wp_send_json_error( ['message' => 'Invalid username or email'] );
        }

        // Generate a password reset key
        $key = get_password_reset_key( $user_data );

        // Store the reset key in user meta
        update_user_meta( $user_data->ID, 'password_reset_key', $key );

        $reset_url = home_url('/login/?action=rp&key='.$key.'&login='.rawurlencode( $user_data->user_login ));

        // add_action( 'wp_mail_failed', [$this,'log_wp_mail_errors'], 10, 1 );
        
        // Send the password reset email
        $subject = 'Password Reset';
        $message = 'Dear '.$user_data->user_login . ','; 
        $message .= '<br /><br /> You can click the following link to reset your password:';
        $message .= '<br /><a href="'.$reset_url.'">Reset Password Link</a>';
        $message .= '<br /><br />Best Regards,';
        $message .= '<br />'.get_bloginfo('name');
        
        $headers    = array( 'Content-Type: text/html; charset=UTF-8' );
        $send_email = wp_mail( $user_data->user_login, $subject, $message, $headers );
        if ( $send_email ) {
            wp_send_json_success( 'Password reset email sent' );
            exit;
        } 
            
        wp_send_json_error( ['message' => 'Failed to send password reset email'] );
        
    }
}

if(!class_exists('MPForgotPasswrodAjax')){
    new MPForgotPasswrodAjax();
}
