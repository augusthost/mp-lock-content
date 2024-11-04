<?php

namespace MP\filters;

use DOMDocument;
use DOMXPath;
use MP\services\MPMiddleware;

class MPFilterContent{
    
    public function __construct()
    {
        add_filter('the_content',[$this,'mp_filter_post_content']);
    }

    protected function getLockLayer(){

        $redirect_to = '';
        if(!is_user_logged_in() && is_single()){
            $redirect_to = get_permalink();
        }

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

    protected function isElementorPage($html){
        $dom = new DOMDocument();

        libxml_use_internal_errors(true);

        // Load HTML content
        $dom->loadHTML($html);

        libxml_use_internal_errors(false);

        // Create DOMXPath object
        $xpath = new DOMXPath($dom);

        // Find the element with class 'elementor-text-editor'
        $element = $xpath->query('//div[contains(@class, "elementor-text-editor")]');

        return $element->length > 0;
    }
    
    public function mp_filter_post_content($content){

        // Allow
        if(MPMiddleware::isUserCanRead()){
            // remove [lock_content] only when user can read
            if (strpos($content, '[lock_content]') !== false) {
                $content = str_replace('[lock_content]', '', $content);
                $content = str_replace('[/lock_content]', '', $content);
            }
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

    /**
     *  Get N paragraphs
     */
    function getNParagraphs(string $html, $num) {
        preg_match_all('/<[^>]+>.*?<\/[^>]+>/', $html, $matches);
        $result = implode("\n", array_slice($matches[0], 0, $num));
        return $result;
    }

    protected function removeShortcodeContent($content) {
        $pattern = '/\[lock_content\](.*?)\[\/lock_content\]/s';
        $replacement = '';
        $content = preg_replace($pattern, $replacement, $content);
        return $content;
    }

    protected function getPreviewContent($content){
        if(empty($content)) return '';

        // restrict with shortcode
        if (strpos($content, '[lock_content]') !== false) {
            return $this->removeShortcodeContent($content);
        }

        // fallback default restrict
        global $mppluginSetting;
        $num = $mppluginSetting->get_setting('limit_paragraph_num') ? $mppluginSetting->get_setting('limit_paragraph_num') : 4;

        // If Elementor Page
        if($this->isElementorPage($content)){
            return $this->getNParagraphs($content, $num + 12);
        }

        return $this->getNParagraphs($content, $num);
    }
}

if(!class_exists('MPFilterContent')){
    new MPFilterContent();
}