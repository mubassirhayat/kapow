<?php

class KPServer
{
    public static function pathInfo()
    {
        return self::get( 'PATH_INFO' );
    }

    public static function requestUri()
    {
        return self::get( 'REQUEST_URI' );
    }

    public static function requestMethod()
    {
        return self::get( 'HTTP_REQUEST_METHOD' );
    }

    public static function get( $property, $default = null )
    {
        if ( array_key_exists( $property, $_SERVER ) )
            return $_SERVER[ $property ];

        return $default;
    }
}