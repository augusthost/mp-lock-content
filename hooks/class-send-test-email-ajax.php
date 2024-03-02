<?php

namespace MP\hooks;

use MP\services\MPEmailService;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MPSendTestEmailAjax
{
    public function __construct()
    {
        add_action('wp_ajax_test_email', [$this, 'test_email_callback']);
    }


    public function test_email_callback()
    {
        $template = sanitize_text_field($_POST['template'] );
        $email    = sanitize_email($_POST['email'] );

        if(empty($email)){
            wp_send_json_error( ['message' => 'Test email address is required.'] );
        }

        if(empty($template)){
            wp_send_json_error( ['message' => 'Template is required.'] );
        }

        $send_email = (new MPEmailService())->send($email, $template, []);
        if (!$send_email ) {
            wp_send_json_error( ['message' => 'Failed to send test email'] );
        } 

        wp_send_json_success( 'Successfully sent test email.' );
        exit();
    }
}

if(!class_exists('MPSendTestEmailAjax')){
    new MPSendTestEmailAjax();
}
