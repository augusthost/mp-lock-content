<?php

namespace MP\hooks;

class MPInitHook{

    public function __construct()
    {
        add_action( 'admin_init', [ $this, 'check_disable_login_plugin'] );
    }

    public function check_disable_login_plugin() {
        if (!defined('SS_DISABLE_USER_LOGIN_FILE')) {
            add_action( 'admin_notices', [ $this, 'disable_login_missing_notice'] );
        }
    }
    
    public function disable_login_missing_notice() {
        $message = 'Please install and activate the <a href="/wp-admin/plugin-install.php?s=Disable%2520User%2520Login&tab=search&type=term">Disable User Login plugin</a> because mp-lock-content plugin needs it.';
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php echo $message; ?></p>
        </div>
        <?php
    }
    
}

if(!class_exists('MPInitHook')){
    new MPInitHook();
}