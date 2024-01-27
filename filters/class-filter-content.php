<?php

namespace MP\filters;

use MP\services\MPMiddleware;

class MPFilterContent{
    
    public function __construct()
    {
        add_filter('the_content',[$this,'mp_filter_post_content']);
    }

    protected function getLockLayer(){
        ob_start();
        require_once MP_LOCK_CONTENT_PATH . '/view/lock-layer.php';
        return ob_get_clean();
    }

    protected function isCategoryMatch($cat_id) : bool{
        // Check if the current post has categories
        if (!has_category()) return false;
        
        global $post;
        $categories = get_the_category($post->ID);
        // Loop through each category
        foreach ($categories as $category) {
            // Get the category name and link
            if($category->term_id == $cat_id){
                return true;
            }
        
        }

        return false;
    }
    
    public function mp_filter_post_content($content){

        // Allow
        if(MPMiddleware::isUserCanRead()){
            return $content;
        }

        global $mppluginSetting;
        $lock_cat = $mppluginSetting->get_setting('locked_cat') ?? '';
        
        if(!$this->isCategoryMatch($lock_cat)) return $content;

        // Lock
        $preview_content  = $this->getPreviewContent($content);
        $lock_layer       = $this->getLockLayer();
        $preview_and_lock = $preview_content . $lock_layer;

        return $preview_and_lock;
    }

    protected function getPreviewContent($content){
        $content_length = strlen($content);
        $half           = (int)$content_length / 1.5;
        $preview        = substr($content, 0, (int)$half);
        return $preview;
    }
}

if(!class_exists('MPFilterContent')){
    new MPFilterContent();
}