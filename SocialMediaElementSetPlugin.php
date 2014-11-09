<?php

class SocialMediaElementSetPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array(
            'install',
            'uninstall',
            'public_head',
            //'after_save_item'
            );
    
    protected $_filters = array(
            'filterTwitter'   => array('Display', 'Item', 'Social Media Elements', 'Twitter'),
            'filterTumblr'    => array('Display', 'Item', 'Social Media Elements', 'Tumblr'),
            'filterFlickr'    => array('Display', 'Item', 'Social Media Elements', 'Flickr'),
            'filterFacebook'  => array('Display', 'Item', 'Social Media Elements', 'Facebook'),
            'filterGitHub'    => array('Display', 'Item', 'Social Media Elements', 'GitHub'),
            'filterInstagram' => array('Display', 'Item', 'Social Media Elements', 'Instagram'),
            'filterVimeo'     => array('Display', 'Item', 'Social Media Elements', 'Vimeo'),
            'filterYoutube'   => array('Display', 'Item', 'Social Media Elements', 'YouTube'),
            'filterLinkedin'  => array('Display', 'Item', 'Social Media Elements', 'Linked In'),
            'filterUntappd'   => array('Display', 'Item', 'Social Media Elements', 'Untappd'),
            'filterLinkedin'   => array('Display', 'Item', 'Social Media Elements', 'Linked In'),
            );

    protected $_elements = array(
            'Twitter',
            'Tumblr',
            'Flickr',
            'Facebook',
            'GitHub',
            'Instagram',
            'Vimeo',
            'YouTube',
            'Linked In',
            //'Untappd'
            );
    public function hookAfterSaveItem($args)
    {
        $post = $args['post'];
        $this->validateTwitter($post);
        $this->validateFlickr($post);
    }
    
    public function hookPublicHead($args)
    {
        queue_css_file('social_media_element_set');
    }
    public function filterTwitter($value, $args)
    {
        $imgUrl = img('twitter.png');
        $link = "<a href='http://twitter.com/$value' class='social-media-element' style='background-image: url($imgUrl)' >$value</a>";
        return $link; 
    }
    public function filterTumblr($value, $args)
    {
        $imgUrl = img('tumblr.png');
        $link = "<a href='http://$value.tumblr.com' class='social-media-element'  style='background-image: url($imgUrl)' >$value</a>";
        return $link; 
    }
    public function filterFlickr($value, $args)
    {
        $imgUrl = img('flickr.png');
        //@TODO: in some cases the username doesn't match to the URL. In those cases, need to query API a couple times to dig up id from findByUsername, then url via findInfo
        $link = "<a href='https://www.flickr.com/photos/$value'  class='social-media-element'  style='background-image: url($imgUrl)' >$value</a>";
        return $link; 
    }

    public function filterFacebook($value, $args)
    {
        $imgUrl = img('facebook.png');
        $link = "<a href='http://facebook.com/$value'  class='social-media-element'  style='background-image: url($imgUrl)' >$value</a>";
        return $link; 
    }

    public function filterGitHub($value, $args)
    {
        $imgUrl = img('Github.png');
        $link = "<a href='http://github.com/$value'  class='social-media-element'  style='background-image: url($imgUrl)' >$value</a>";
        return $link; 
    }

    public function filterVimeo($value, $args)
    {
        $imgUrl = img('vimeo.png');
        $link = "<a href='http://vimeo.com/$value'  class='social-media-element'  style='background-image: url($imgUrl)'  >$value</a>";
        return $link; 
    }
    
    public function filterYoutube($value, $args)
    {
        $imgUrl = img('youtube.png');
        $link = "<a href='https://www.youtube.com/user/$value'  class='social-media-element'  style='background-image: url($imgUrl)'  >$value</a>";
        return $link; 
    }
        
    public function filterLinkedin($value, $args)
    {
        $imgUrl = img('linkedin.png');
        $link = "<a href='https://www.linkedin.com/profile/view?id=$value'  class='social-media-element'  style='background-image: url($imgUrl)' >$value</a>";
        return $link; 
    }

    public function filterInstagram($value, $args)
    {
        $imgUrl = img('Instagram.png');
        $link = "<a href='http://instagram.com/$value'  class='social-media-element'  style='background-image: url($imgUrl)' >$value</a>";
        return $link; 
    }

    public function filterUntappd($value, $args)
    {
        $imgUrl = img('untappd.png');
        $link = "<a href='http://untappd.com/$value'  class='social-media-element'  style='background-image: url($imgUrl)' >$value</a>";
        return $link; 
    }
    
    public function hookInstall()
    {
        $this->installElements();
    }
    
    public function hookUninstall()
    {
        
        
    }
    
    public function socialMediaLinksList($item, $showEmpty = false)
    {
        $list = "<ul class='social-media-list'>";
        
        foreach ($this->_elements as $element) {
            //check without filters so I can see if it is empty
            $el = metadata($item, array('Social Media Elements', $element), array('no_filter' => true));
            if ($showEmpty || !empty($el)) {
                //reget the data with the filtered content
                $el = metadata($item, array('Social Media Elements', $element));
                $list .= "<li>";
                $list .= $el;
                $list .= "</li>";
            }
        }
        $list .= "</ul>";
        return $list;
    }
    
    public function filterSocialMediaInput($components, $args)
    {
        $components['input'] = get_view()->formText($args['input_name_stem'], $args['value']);
        return $components;
    }
    
    protected function installElements()
    {
        $elementSetMetadata = array('name' => 'Social Media Elements', 'description' => 'Social Media IDs');
        $elements = array();
        $elements[] = array('name' => 'Twitter', 'description' => __('Username, e.g. patrick_mj'));
        $elements[] = array('name' => 'Facebook', 'description' => __('Username, e.g. HagleyMuseumandLibrary'));
        $elements[] = array('name' => 'Instagram', 'description' => __('Username'));
        $elements[] = array('name' => 'Tumblr', 'description' => __('Username'));
        $elements[] = array('name' => 'Flickr', 'description' => __('Username'));
        $elements[] = array('name' => 'Linked In', 'description' => __('Id, e.g. 1234567'));
        $elements[] = array('name' => 'GitHub', 'description' => __('Username'));
        $elements[] = array('name' => 'YouTube', 'description' => __('Username'));
        $elements[] = array('name' => 'Vimeo', 'description' => __('Username'));
        $elements[] = array('name' => 'Untappd', 'description' => __('Username'));
        insert_element_set($elementSetMetadata, $elements);
    }
}

