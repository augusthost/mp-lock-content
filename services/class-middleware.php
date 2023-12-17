<?php

namespace MP\services;

class MPMiddleware{
    public static function isUserVerified(){
        // Check if the user is not verified
        $user_id = get_current_user_id();
        if(!$user_id) return false;
        $user_verified = get_user_meta($user_id, 'user_verified', true);
        return !empty($user_verified);
    }
    public static function isUserCanRead(){

        if(current_user_can('administrator') ) return true;
        
        if(is_user_logged_in()) return true;

        if(self::isUserVerified()) return true;

         if(!is_singular('post')) return true;

         return false;
    }
}
