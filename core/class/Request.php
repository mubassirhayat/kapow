<?php

class KPRequest
{
    public static function get( $name = null, $default = null )
    {
        if ( null === $name )
            return $_GET;

        if ( isset($_GET[$name]) )
            return $_GET[$name];

        return $default;
    }

    public static function post( $name = null, $default = null )
    {
        if ( null === $name )
            return $_POST;

        if ( isset($_POST[$name]) )
            return $_POST[$name];

        return $default;
    }
}