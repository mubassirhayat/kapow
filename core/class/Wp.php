<?php

class KPWp
{
    protected static $instance = null;

    public static function instance()
    {
        if ( null === self::$instance )
            self::$instance = new self;

        return self::$instance;
    }

    protected function __construct()
    {
    }
    
    protected $widgets    = array();
    protected $sidebars   = array();
    protected $shortcodes = array();
    protected $menus      = array();
    
    public function widget( KPWidget $widget )
    {
        
    }
    
    public function sidebar( KPSidebar $sidebar )
    {
        
    }
    
    public function shortcode( KPShortcode $shortcode )
    {
        
    }
    
    public function menu( $menu )
    {
        
    }
        
}