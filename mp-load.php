<?php


// require_once MP_LOCK_CONTENT_PATH . '/dev-mode.php';
require_once MP_LOCK_CONTENT_PATH . '/shortcodes/class-login-shortcode.php';
require_once MP_LOCK_CONTENT_PATH . '/shortcodes/class-signup-shortcode.php';
require_once MP_LOCK_CONTENT_PATH . '/shortcodes/class-account-shortcode.php';
require_once MP_LOCK_CONTENT_PATH . '/services/class-middleware.php';
require_once MP_LOCK_CONTENT_PATH . '/services/class-message.php';
require_once MP_LOCK_CONTENT_PATH . '/services/class-email.php';

require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-send-test-email-ajax.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-enqueue-scripts.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-signup-ajax.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-login-ajax.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-forgot-password-ajax.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-init-hook.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-reset-password.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-check-email-verification.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-send-email-after-enable.php';
require_once MP_LOCK_CONTENT_HOOKS_DIR . '/class-user-columns.php';


require_once MP_LOCK_CONTENT_FILTERS_DIR . '/class-filter-content.php';
require_once MP_LOCK_CONTENT_FILTERS_DIR . '/class-filter-disable-message.php';

// Admin
require_once MP_LOCK_CONTENT_PATH . '/admin/class-wpsetting.php';
require_once MP_LOCK_CONTENT_PATH . '/admin/class-theme-setting.php';
