<?php

namespace MP\admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * AH Theme Setting
 */

class MPPluginSetting extends WPSetting
{
    public $prefix = 'ah_ahchat'; // this is super recommended

    public function __construct()
    {
        parent::__construct(); // this is required

        // Actions
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_init', [$this, 'ah_bot_redirect']);
    }

    /**
     * Register wp-admin menu
     *
     * @return void
     */
    public function menu() : void
    {
          add_menu_page(
            'Lock Content', // Menu title
            'Lock Content', // Menu label
            'manage_options', // Capability required to access the menu
            'settings-page', // Menu slug
            [$this, 'settings_page'],
            'dashicons-lock', // Icon URL or Dashicons class
            20 // Menu position
        );
    }

    /**
     * Invite code option page
     *
     * @return void
     */
    public function settings_page() : void
    {
        require_once( MP_LOCK_CONTENT_PATH . '/view/admin/settings-page.php');
    }


    function ah_bot_redirect() {
        if (isset($_GET['page']) && $_GET['page'] === 'ah-bot') {
            wp_redirect(admin_url('edit.php?post_type=ah_form'));
            exit;
        }
    }

    
}

$mppluginSetting = new MPPluginSetting();
