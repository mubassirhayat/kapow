<?php

class KPHelper
{
    private $config;
    
    const kScriptPositionHead = 'head';
    const kScriptPositionFoot = 'foot';
    const kAddMethodBefore    = 'before';
    const kAddMethodAfter     = 'after';
    
    protected static $instance = null;

    private function __construct()
    {
        $this->config = KPConfig::instance();
    }

    public static function instance()
    {
        if ( null === self::$instance )
            self::$instance = new self;

        return self::$instance;
    }

    public function getSiteTitle()
    {
        $out       = '';
        $titles    = $this->config->siteTitle();
        $separator = $this->config->siteTitleSeparator();
        
        if( !empty( $titles ) )
        {
            $titles = array_reverse( $titles );
            $out .= implode( " $separator ", $titles ) . " $separator ";
        }
        
        $out .= wp_title( $separator, false, 'right' );
        $out .= get_bloginfo( 'name' );
        
        return $out;
    }
    
    public function getStylesheets()
    {
        if( !is_array( $this->config->stylesheets() ) )
            return;
        
        $styles = array();
        $debug  = $this->config->debugStylesheetAndScripts();
        
        foreach( $this->config->stylesheets() as $stylesheet )
        {
            if( is_array( $stylesheet ) )
            {
                $src   = $stylesheet['src'];
                $media = $stylesheet['media'];
                $rel   = $stylesheet['rel'];
            }
            else if( false !== strpos( $stylesheet, 'http' ) )
            {
                $src   = $stylesheet;
                $media = 'screen';
                $rel   = 'stylesheet';
            }
            else
            {
                $src   = D_STYLE . '/' . $stylesheet;
                $media = 'screen';
                $rel   = 'stylesheet';
            }
            
            if( $debug )
            {
                $initialChar = false !== strpos( $src, '?' ) ? '&' : '?';
                $src .= $initialChar . 'v=' . time();
            }
            
            array_push( $styles, '<link rel="' . $rel . '" href="' . $src . '" type="text/css" media="' . $media . '" />' );
        }
        
        $style = implode( "\n\t", $styles );
        
        return $style . "\n";
    }

    public function getScripts( $position = KPHelper::kScriptPositionHead )
    {
        $scripts  = array();
        $debug    = $this->config->debugStylesheetAndScripts();
        $_scripts = $this->config->get( 'scripts-' . $position );

        if( $this->config->shouldIncludeKaPowJs() && KPHelper::kScriptPositionFoot == $position )
        {
            array_push( $scripts, '<script type="text/javascript" src="' . D_THEME . '/_kapow/_assets/script/KaPow.js' . '"></script>' );
        }

        foreach( $_scripts as $script )
        {
            if( is_array( $script ) )
            {
                $src = $script['src'];
            }
            else if( false !== strpos( $script, 'http' ) )
            {
                $src = $script;
            }
            else
            {
                $src = D_SCRIPT . '/' . $script;
            }
            
            if( $debug )
            {
                $initialChar = false !== strpos( $src, '?' ) ? '&' : '?';
                $src .= $initialChar . 'v=' . time();
            }
            
            array_push( $scripts, '<script type="text/javascript" src="' . $src . '"></script>' );
        }
        
        $script = implode( "\n\t", $scripts );
        
        return $script . "\n";
    }

    public function addJavascriptVariable( $var, $value )
    {
        $this->config->push( 'javascriptVariables', array( $var, $value ) );
    }

    public function getJavascriptVariables()
    {
        $variables  = $this->config->javascriptVariables();
        $_variables = array();

        if( !empty( $variables ) )
        {
            array_push( $_variables, '<script type="text/javascript">' );
        }

        foreach( $variables as $data )
        {
            array_push( $_variables, "{$data[ 0 ]} = '{$data[ 1 ]}';" );
        }

        if( !empty( $variables ) )
        {
            array_push( $_variables, '</script>' );
        }

        $output = implode( "\n\t", $_variables );
        
        return $output . "\n";   
    }

    public function addStylesheets( $stylesheets, $type = KPHelper::kAddMethodAfter )
    {
        foreach( $stylesheets as $stylesheet )
        {
            $this->addStylesheet( $stylesheet, $type );
        }
    }

    public function addStylesheet( $stylesheet, $type = KPHelper::kAddMethodAfter )
    {
        if( !is_array( $stylesheet ) )
        {
            if( $type == KPHelper::kAddMethodAfter )
            {
                $this->config->push( 'stylesheets', $stylesheet );
            }
            else
            {
                $this->config->unshift( 'stylesheets', $stylesheet );
            }
        }
        else
        {
            foreach( $stylesheet as $s )
            {
                if( $type == KPHelper::kAddMethodAfter )
                {
                    $this->config->push( 'stylesheets', $s );
                }
                else
                {
                    $this->config->unshift( 'stylesheets', $s );
                }
            }
        }
    }

    public function addScripts( $scripts, $position = KPHelper::kScriptPositionHead, $type = KPHelper::kAddMethodAfter )
    {
        foreach( $scripts as $script )
        {
            $this->addScript( $script, $position, $type );
        }
    }

    public function addScript( $script, $position = KPHelper::kScriptPositionHead, $type = KPHelper::kAddMethodAfter )
    {
        if( !is_array( $script ) )
        {
            if( $type == KPHelper::kAddMethodAfter )
            {
                $this->config->push( 'scripts-' . $position, $script );
            }
            else
            {
                $this->config->unshift( 'scripts-' . $position, $script );
            }
        }
        else
        {
            foreach( $script as $s )
            {
                if( $type == KPHelper::kAddMethodAfter )
                {
                    $this->config->push( 'scripts-' . $position, $s );
                }
                else
                {
                    $this->config->unshift( 'scripts-' . $position, $s );
                }
                
            }
        }
    }

    public function includeHeaderMetadata()
    {
        global $app;
        
        if( file_exists( $file = STYLESHEETPATH . '/header-metadata.php' ) )
        {
            include $file;
        }
    }
    
    public function includeFooterMetadata()
    {
        global $app;
        
        if( file_exists( $file = STYLESHEETPATH . '/footer-metadata.php' ) )
        {
            include $file;
        }
    }

    public function addSiteTitle( $title )
    {
        if( !is_array( $title ) )
        {
            $this->config->push( 'siteTitle', $title );
        }
        else
        {
            foreach( $title as $t )
            {
                $this->config->push( 'siteTitle', $t );
            }
        }
    }

    public function addBodyClass( $class )
    {
        if( !is_array( $class ) )
        {
            $this->config->push( 'classes', $class );
        }
        else
        {
            foreach( $class as $c )
            {
                $this->config->push( 'classes', $c );
            }
        }
    }
}