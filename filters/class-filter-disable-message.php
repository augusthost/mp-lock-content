<?php

namespace MP\filters;

class MPDisableMessage{
    
    public function __construct()
    {
        add_filter( 'disable_user_login.disabled_message', [$this, 'mp_disable_message'] , 10, 1 );
    }

    
    public function mp_disable_message( $disabled_message ) {
        global $mppluginSetting;

        $disabled_message = $mppluginSetting->get_setting('disabled_message') ?  $mppluginSetting->get_setting('disabled_message') : '<strong>Account Disabled:</strong> Requires Administrator Approval';
        return $disabled_message;
     }
}

if(!class_exists('MPDisableMessage') && defined('SS_DISABLE_USER_LOGIN_FILE')){
    new MPDisableMessage();
}

