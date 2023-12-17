<?php

namespace MP\hooks;

class MPCheckVerification
{
    public function __construct()
    {
        add_action('template_redirect', [$this, 'check_verification_code']);
        add_action('the_content', [$this, 'checkVerified']);
    }

    public function check_verification_code()
    {       

       if(!isset($_GET['verify_code'])) return;

       // Get the verification code from the query string
       $verification_code = $_GET['verify_code'];

       $users = get_users(array(
        'meta_key'   => 'verification_code',
        'meta_value' => $verification_code,
        'fields'     => 'ID',
       ));

       if(empty($users)){
            // Redirect the user to the error page
            wp_redirect(home_url('/?message=no_verified_email'));
            exit;
       }
       
        // Update the user's meta data to mark them as verified
        update_user_meta($users[0], 'user_verified', true);

        // Redirect the user to the success page
        wp_redirect(home_url('/?message=verified_email'));
        exit;
    }

    public function checkVerified($content){

        if( current_user_can('administrator') ) {
            return $content;
        }

         // Check if the user is not verified
         $user_id = get_current_user_id();
         if(!$user_id) return $content;
         $user_verified = get_user_meta($user_id, 'user_verified', true);

         // If the user is verified
         if ($user_verified) {
             return $content;
         }

        return '<div style="z-index:9;margin:1rem auto 1rem auto; background:#fffde4; border-radius:4px; box-shadow:0 1px 10px #eee; text-align:center; max-width:1000px; padding:10px;">Your account is not activated. <br /> Please click on the verification link sent to your email.</div>' . $content;

    }

}


if(!class_exists('MPCheckVerification')){
    new MPCheckVerification();
}