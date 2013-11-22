<?php

class KPString
{
    public static function camelize( $string )
    {
        return preg_replace_callback(
            '/_\D/',
            create_function( '$match', 'return strtoupper( substr( $match[ 0 ], 1 ) );' ),
            $string
        );
    }

    public static function hyphenate( $string )
    {
        return preg_replace_callback(
            '/[A-Z]/',
            create_function( '$match', 'return "_" . strtolower( $match[ 0 ] );' ),
            strtolower( substr( $string, 0, 1 ) ) . substr( $string, 1 )
        );
    }
    
    public static function truncate( $string, $limit = 20, $separator = '…' )
    {
    	return $string;
    }
    
    public static function slugify( $value )
    {
	 	$value = preg_replace( '~[^\\pL\d]+~u', '-', $value );
	 	$value = trim( $value, '-' );
	  	$value = iconv( 'utf-8', 'us-ascii//TRANSLIT', $value );
	  	$value = strtolower( $value );
	  	$value = preg_replace( '~[^-\w]+~', '', $value );

		return $value;
    }
}