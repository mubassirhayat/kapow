<?php

class KPConfig
{
    protected static $instance = null;

    public static function instance()
    {
        if ( null === self::$instance )
            self::$instance = new self;

        return self::$instance;
    }

    protected $data = array();

    protected function __construct()
    {
        if ( is_file( $file = KP_CORE . DS . 'config.php' ) )
            $this->data = require_once $file;
    }
    
    public function set( $option, $value )
    {
        $this->data[ $option ] = $value;
    }
   
    public function push( $option, $value )
    {
        if( !isset( $this->data[ $option ] ) || !is_array( $this->data[ $option ] ) )
        {
            $this->data[ $option ] = array();
        }
        
        array_push( $this->data[ $option ], $value );
    }
    
    public function unshift( $option, $value )
    {
        if( !is_array( $this->data[ $option ] ) )
        {
            $this->data[ $option ] = array();
        }
        
        array_unshift( $this->data[ $option ], $value );
    }
    
    public function get( $name )
    {
        if( !array_key_exists( $name, $this->data ) )
            return false;
        
        return $this->data[ $name ];
    }
    
    public function __call( $option, $params )
    {
        if( !array_key_exists( $option, $this->data ) && !$params )
        {
            return null;
        }

        if( !array_key_exists( $option, $this->data ) && $params )
        {
            $this->data[ $option ] = $params[0];
            return $params[0];
        }
        
        if( $params )
            $this->data[ $option ] = $params[0];
        
        return $this->data[ $option ];
    }
}