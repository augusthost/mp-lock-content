<?php
/**
 * Plugin Name: MP lock content
 * Description: Lock Content like Mediumn
 * Plugin URI:  https://augusthost.com/
 * Version:     1.0.1
 * Author:      August Host
 * Author URI:  https://augusthost.com/
 * Text Domain: mp-lock-content
 *
 */

define('MP_LOCK_CONTENT_DIR', plugin_dir_url(__FILE__));
define('MP_LOCK_CONTENT_PATH', WP_PLUGIN_DIR . '/mp-lock-content');
define('MP_LOCK_CONTENT_HOOKS_DIR', MP_LOCK_CONTENT_PATH . '/hooks');
define('MP_LOCK_CONTENT_FILTERS_DIR', MP_LOCK_CONTENT_PATH . '/filters');

require_once plugin_dir_path(__FILE__) . '/mp-load.php';


// Hide admin bar for all subscriber
function hide_admin_bar_for_subscribers() {
    if (current_user_can('subscriber')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'hide_admin_bar_for_subscribers');


// Hide wp-login.php
function custom_login_page() {
    if (strpos($_SERVER['REQUEST_URI'], '/wp-login.php') !== false) {
        wp_redirect(home_url('/login/'));
        exit();
    }
}
add_action('init', 'custom_login_page');
