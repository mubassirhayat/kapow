<?php

class KPDb
{
    protected static $instance = null;

    public static function instance()
    {
        if ( null === self::$instance )
            self::$instance = new self;

        return self::$instance;
    }
    
    protected $db = null;
    
    protected function __construct()
    {
        global $wpdb;
        
        $this->db = $wpdb;
    }
    
    public function option( $name, $default = '' )
    {
        return $default;
    }
}