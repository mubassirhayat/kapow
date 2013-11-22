<?php

class KPImage
{
    protected $_url;
    protected $_originalUrl = '';
    protected $_attrs       = array();
    protected $_thumburl    = '';
    
    public function __construct( $object )
    {
        $this->_thumbUrl = D_VENDOR . '/lib/timthumb.php';
        
        if( is_object( $object ) )
        {
            $this->_url         = $this->getWordpressFeaturedImageUrl( $object );
            $this->_originalUrl = $this->_url;
        }
        else
        {
            $this->_url         = $object;
            $this->_originalUrl = $this->_url;
        }
    }
    
    public function getWordpressFeaturedImageUrl( $_post = null )
    {
        global $post;
        
        if( null == $_post )
            $_post = $post;

        $imgId       = get_post_thumbnail_id( $_post->ID );
        $originalImg = wp_get_attachment_image_src( $imgId, 'original' );
        
        return $originalImg[ 0 ];
    }
    
    public static function init( $object )
    {
        return new self( $object );
    }
    
    public static function getImageOrientation( $imageURL )
    {
        if( $imageURL == '' )
            return 'no-string';
        
        if( !$size = @getimagesize( $imageURL ) )
            return 'cant-get-size';
    
        return ( $size[1] / $size[0] ) >= 1 ? 'portrait' : 'landscape';
    }
    
    public function hasFeaturedImage()
    {
        return strlen( $this->_url ) ? true : false;
    }
    
    public function resize( $width, $height = 0 )
    {
        $this->_url = $this->_thumbUrl . '?src=' . $this->_url . '&w=' . $width . '&h=' . $height;
        return $this;
    }
    
    public function attr( $name, $value )
    {
        $this->_attrs[ $name ] = $value;
        
        return $this;
    }
    
    public function url()
    {
        return $this->_url;
    }
    
    public function html()
    {
        $attributes = array();

        foreach( $this->_attrs as $name => $value )
        {
            array_push( $attributes, "$name=\"$value\"" );
        }

        return '<img src="'. $this->_url .'" '. implode( ' ', $attributes ) .' />';
    }
}