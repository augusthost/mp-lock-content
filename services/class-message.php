<?php

namespace MP\services;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Flash Message
 */
class MPMessage
{
    public const MESSAGES_ARRAY = [
        [
            'key'     => 'test_msg',
            'message' => 'This a test message',
            'type'    => 'success'
        ],
        [
            'key'     => 'verified_email',
            'message' => 'Successfully verified your email address.',
            'type'    => 'success'
        ],
        [
            'key'     => 'no_verified_email',
            'message' => 'Sorry, failed to verified your email address.',
            'type'    => 'error'
        ]
    ];

    public function __construct()
    {
        // for frontend
        add_filter('the_content', [$this, 'flash_messages']);
        add_filter('wp_head', [$this, 'flash_messages_styles']);
        add_filter('wp_footer', [$this, 'flash_messages_scripts']);

        // for admin
        add_action('admin_notices', [$this, 'showErrorMessage']);
        add_action('admin_notices', [$this, 'showSuccessMessage']);
    }

    public function flash_messages_styles(){
        echo '<style>
        .flash-message.error{
            color:red;
            background:#fcc0c0;
            padding:.5rem;
            margin:1rem 0 1rem;
            text-align:center;
            font-size:1rem;
            box-shadow:0 1px 10px #00000024;
        }
        
        .flash-message.success{
            color:green;
            background:#ceffce;
            padding:.5rem;
            margin:1rem 0 1rem;
            text-align:center;
            font-size:1rem;
            box-shadow:0 1px 10px #00000024;
        }
        </style>';
    }

    public function flash_messages_scripts()
    {
        echo '<script>
        jQuery( function( $ ) {
            window.history.replaceState(null, null, window.location.pathname);
            setTimeout(function(){
                $(".flash-message").fadeOut();
            },4000)
        })
        </script>';
    }

    protected static function success(string $msg): string
    {
        return '<div class="flash-message success">'.$msg.'</div>';
    }

    protected static function error(string $msg): string
    {
        return '<div class="flash-message error">'.$msg.'</div>';
    }

    protected function isExitInMessageArray($param)
    {
        $message = null;
        foreach (self::MESSAGES_ARRAY as $msg) {
            if ($msg['key'] === $param) {
                $message = $msg;
            }
        }
        return $message;
    }

    public function flash_messages($content)
    {
        if (!isset($_GET['message'])) {
            return $content;
        }
        $param   = $_GET['message'];
        $message = $this->isExitInMessageArray($param);
        if (empty($message)) {
            return $content;
        }
        $message = $message['type'] === 'success' ? $this->success($message['message']) : $this->error($message['message']);
        return  $message . $content;
    }


    /**
     *   Shows custom errors in wordpress admin panel
     */
    public function showErrorMessage(): void
    {
        if(!is_admin()) {
            return;
        }
        $errors = get_option('gmi_errors');

        if (empty($errors)) {
            return;
        }

        $errors = json_decode($errors);
        foreach($errors as $error):
            echo '<div class="error notice notice-error is-dismissible">';
            echo '<p>'.$error.'</p>';
            echo '</div>';
        endforeach;

        // Reset the option
        update_option('gmi_errors', false);
    }

     /**
      *   Shows custom errors in wordpress admin panel
      */
    public function showSuccessMessage(): void
    {
        if(!is_admin()) {
            return;
        }
        $success = get_option('gmi_success');

        if (empty($success)) {
            return;
        }

        $success = json_decode($success);
        foreach($success as $success):
            echo '<div class="updated notice notice-success is-dismissible">';
            echo '<p>'.$success.'</p>';
            echo '</div>';
        endforeach;

        // Reset the option
        update_option('gmi_success', false);
    }
}

if (!class_exists('MPMessage')) {
    new MPMessage();
}
