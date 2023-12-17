<?php

namespace MP\hooks;

class MPEnqueueScripts{
    protected $pages = ['login','sign-up','account'];
    public function __construct()
    {
        add_action('wp_enqueue_scripts',[$this,'mp_enqueue_scripts']);
        add_action('wp_head',[$this,'mp_hide_header_banner']);
    }

    public function mp_hide_header_banner(){

        global $post;

        if(empty($post)) return;

        if(!in_array($post->post_name,$this->pages)) return;

        echo '<style>
        #page,.site-main{
            background:#f6f7f9;
        }
        .wraper_blog_main>.container{
            padding-top:5rem;
        }
        .wraper_inner_banner{
            display:none;
        }
        </style>';
    }

    protected function isPageToEnqueue(){
        global $post;
        if(empty($post)) return false;

        if(in_array($post->post_name,$this->pages)){
            return true;
        }

        return is_singular('post');
    }

    public function mp_enqueue_scripts(){

        if(!$this->isPageToEnqueue()) return;

        wp_enqueue_style('mp-lock', MP_LOCK_CONTENT_DIR . 'dist/mp-lock.css');
        wp_enqueue_script('mp-lock', MP_LOCK_CONTENT_DIR . 'dist/mp-lock.js');
    }
}

if(!class_exists('MPEnqueueScripts')){
    new MPEnqueueScripts();
}