<?php

namespace MP\hooks;

class MPInitHook{

    public function __construct()
    {
        add_action( 'admin_init', [ $this, 'check_disable_login_plugin'] );
        add_action( 'admin_init', [ $this, 'check_email_templates_plugin'] );
        add_action( 'admin_menu', [ $this, 'change_email_templates_menu_link'] , 80);
    }

    protected function get_customizer_link() {
		$link = add_query_arg(
			array(
				'url'             => urlencode( site_url( '/?mailtpl_display=true' ) ),
				'return'          => urlencode( admin_url() ),
				'mailtpl_display' => 'true'
			),
			'customize.php'
		);

		return $link;
	}

    public function change_email_templates_menu_link() {
        global $menu;
        
        // Loop through the menu items to find the "Email Templates" menu
        foreach ( $menu as $key => $item ) {
            if ( $item[0] === 'Email Templates' ) {
                // Replace 'example' with your desired new URL
                $menu[ $key ][2] = $this->get_customizer_link();
                break;
            }
        }
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

    public function check_email_templates_plugin() {
        if (!class_exists('Mailtpl_Woomail_Composer')) {
            add_action( 'admin_notices', [ $this, 'email_templates_missing_notice'] );
        }
    }
    
    public function email_templates_missing_notice() {
        $message = 'Please install and activate the <a href="/wp-admin/plugin-install.php?s=Email%2520Templates%2520Customizer%2520and%2520Designer%2520for%2520WordPress%2520and%2520WooCommerce&tab=search&type=term">Email Templates Customizer and Designer for WordPress and WooCommerce</a> because mp-lock-content plugin needs it.';
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