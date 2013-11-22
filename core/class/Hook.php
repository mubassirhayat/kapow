<?php 

class KPHook
{
    protected static $instance = null;

    public static function instance()
    {
        if ( null === self::$instance )
            self::$instance = new self;

        return self::$instance;
    }
    
    public function registerPostTypes( Array $postTypes )
    {
        $posts = array();
        
        foreach( $postTypes as $postType )
        {
            $file  = basename( $postType );
            $class = str_replace( '.php', '', basename( $postType ) );
            
            if( file_exists( $postTypeFile = KP_APP_POST_TYPE . DS . $file ) )
            {
                include $postTypeFile;
            }
            else if( file_exists( $postTypeFile = KP_POST_TYPE . DS . $file ) )
            {
                include $postTypeFile;
            }
            
            array_push( $posts, new $class );
        }
        
        return $posts;
    }
    
    public function registerNavMenus( Array $menus )
    {
        if( function_exists( 'register_nav_menus' ) && !empty( $menus ) )
        {
            register_nav_menus( $menus );
        }
    }
    
    public function registerSidebars( Array $sidebars )
    {
        if( function_exists( 'register_sidebar' ) && !empty( $sidebars ) )
        {
            foreach( $sidebars as $sidebar )
            {
                register_sidebar( $sidebar );
            }
        }
    }
    
    public function addPermalinks( Array $permalinks )
    {
        KPConfig::instance()->permalinks( $permalinks );
    }
    
    public function addImageSizes( Array $sizes )
    {
        if( function_exists( 'add_image_size' ) && !empty( $sizes ) )
        { 
            foreach( $sizes as $size )
            {
                add_image_size( $size['name'], $size['width'], $size['height'], $size['crop'] );
            }
        }
    }
    
    public function addThemeSupports( Array $supports )
    {
        if( function_exists( 'add_theme_support' ) && !empty( $supports ) )
        {
            foreach( $supports as $support )
            {
                if( is_array( $support ) )
                {
                    add_theme_support( $support[0], $support[1] ? $support[1] : array() );
                }
                else
                {
                    add_theme_support( $support );
                }
            }
        }
    }
    
    public function addStylesheets( Array $stylesheets )
    {
        if( !empty( $stylesheets ) )
        {
            foreach( $stylesheets as $stylesheet )
            {
                KPConfig::instance()->push( 'stylesheets', $stylesheet );
            }
        }
    }

    public function addScripts( Array $scripts )
    {
        if( !empty( $scripts ) )
        {
            foreach( $scripts as $position => $files )
            {
                foreach( $files as $script )
                {
                    KPConfig::instance()->push( 'scripts-' . $position, $script );
                }
            }
        }
    }
}