<?php


require_once MP_LOCK_CONTENT_PATH . '/shortcodes/class-login-shortcode.php';
require_once MP_LOCK_CONTENT_PATH . '/shortcodes/class-signup-shortcode.php';
require_once MP_LOCK_CONTENT_PATH . '/shortcodes/class-account-shortcode.php';
require_once MP_LOCK_CONTENT_PATH . '/services/class-middleware.php';
require_once MP_LOCK_CONTENT_PATH . '/services/class-message.php';
require_once MP_LOCK_CONTENT_PATH . '/services/class-email.php';

require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-enqueue-scripts.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-signup-ajax.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-login-ajax.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-forgot-password-ajax.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-init-hook.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-reset-password.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-check-email-verification.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-send-email-after-enable.php';


require_once MP_LOCK_CONTENT_FILTERS_DIR . '/class-filter-content.php';
require_once MP_LOCK_CONTENT_FILTERS_DIR . '/class-filter-disable-message.php';


// Admin
require_once MP_LOCK_CONTENT_PATH . '/admin/class-wpsetting.php';
require_once MP_LOCK_CONTENT_PATH . '/admin/class-theme-setting.php';


if (!function_exists('write_log')) {

 function write_log($log)
 {
     if (true === WP_DEBUG) {
         if (is_array($log) || is_object($log)) {
             error_log(print_r($log, true));
             return;
         }

         error_log($log);
     }
 }
}

if (!function_exists('dd')) {
 function dd($data)
 {
     ini_set("highlight.comment", "#969896; font-style: italic");
     ini_set("highlight.default", "#FFFFFF");
     ini_set("highlight.html", "#D16568");
     ini_set("highlight.keyword", "#7FA3BC; font-weight: bold");
     ini_set("highlight.string", "#F2C47E");
     $output = highlight_string("<?php\n\n" . var_export($data, true), true);
     echo "<div style=\"background-color: #1C1E21; padding: 1rem\">{$output}</div>";
     die();
 }
}