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
            //'filterFacebook'  => array('Display', 'Item', 'Social Media Elements', 'Facebook'),
            'filterGitHub'    => array('Display', 'Item', 'Social Media Elements', 'GitHub'),
            //'filterInstagram' => array('Display', 'Item', 'Social Media Elements', 'Instagram'),
            'filterVimeo'     => array('Display', 'Item', 'Social Media Elements', 'Vimeo'),
            'filterYoutube'   => array('Display', 'Item', 'Social Media Elements', 'Youtube'),
            'filterLinkedin'   => array('Display', 'Item', 'Social Media Elements', 'Linked In'),
            //'filterUntappd'   => array('Display', 'Item', 'Social Media Elements', 'Untappd'),
            );

    protected $_elements = array(
            'Twitter',
            'Tumblr',
            //'Flickr',
            //'Facebook',
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
        $link = "<a href='http://twitter.com/$value'  class='social-media-element'  style='background-image: url($imgUrl)' >$value</a>";
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
        $link = "<a href='http://twitter.com/$value'  class='social-media-element'  style='background-image: url($imgUrl)'  >$value</a>";
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
        $imgUrl = img('instagram.png');
        $link = "<a href='http://twitter.com/$value'  class='social-media-element'  style='background-image: url($imgUrl)' >$value</a>";
        return $link; 
    }
    
    
    public function hookInstall()
    {
        $this->installElements();
    }
    
    public function hookUninstall()
    {
        
        
    }
    
    public function socialMediaLinksList($item)
    {
        $list = "<ul class='social-media-list'>";
        foreach ($this->_elements as $element)
        {
            $el = metadata($item, array('Social Media Elements', $element), array('no_filter' => true));
            if (!empty($el)) {
                $el = metadata($item, array('Social Media Elements', $element));
                $list .= "<li>";
                $list .= $el;
                $list .= "</li>";
            }
        }
        $list .= "</ul>";
        return $list;
    }
    
    protected function installElements()
    {
        $elementSetMetadata = array('name' => 'Social Media Elements', 'description' => 'Social Media IDs');
        
        $elements = array();
        $elements[] = array('name' => 'Twitter');
        $elements[] = array('name' => 'Facebook');
        $elements[] = array('name' => 'Instagram');
        $elements[] = array('name' => 'Tumblr');
        $elements[] = array('name' => 'Flickr');
        $elements[] = array('name' => 'Linked In');
        $elements[] = array('name' => 'GitHub');
        $elements[] = array('name' => 'YouTube');
        $elements[] = array('name' => 'Vimeo');
        $elements[] = array('name' => 'Untappd');
        insert_element_set($elementSetMetadata, $elements);
    }

}
