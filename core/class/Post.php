<?php

class KPPost
{
    protected static $instance = null;

    public static function instance()
    {
        if ( null === self::$instance )
            self::$instance = new self;

        return self::$instance;
    }

    private $_post;
    
    protected function __construct()
    {
        global $post;
        
        $this->_post = $post;
    }
}