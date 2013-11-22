<?php

class KPPostType 
{
    protected $postType;
    protected $postTypeOptions;
    protected $postCustomBoxes;
    protected $postTaxonomies;
    
    const KPBoxTypeNextGen = 'boxTypeNextGen';
    
    protected function boxes(){}
    
    public function __construct()
    {
        $this->boxes();
        
        add_action( 'init', array( $this, 'postInit' ) );
        add_action( 'admin_init', array( $this, 'postCustomBoxes' ) );
        add_action( 'manage_posts_custom_column', array( $this, 'postCustomColumnsManage' ), 10, 2 );
    }
    
    public function postInit()
    {
        if( !post_type_exists( $this->postType ) )
        {
            register_post_type( $this->postType, $this->postTypeOptions );
            add_filter( 'manage_' . $this->post_type . '_posts_columns', array( $this, 'postCustomColumnsAdd' ) );
        }
        
        if( is_array( $this->postTaxonomies ) && function_exists( 'register_taxonomy' ) )
        {
            foreach( $this->postTaxonomies as $name => $taxonomy )
            {
                if( !is_array( $taxonomy ) )
                {
                    $opt = array(
                        'hierarchical' => true,
                        'labels'       => array(
                            'name' => _x( $taxonomy, 'taxonomy general name' ),
                        ),
                        'show_ui'      => true,
                        'query_var'    => true,
                        'rewrite'      => array( 'slug' => $name ),
                    );
                }
                else $opt = $taxonomy;
                
                register_taxonomy( $name, $this->postType, $opt );
            }
        }
    }
    
    public function postCustomBoxes()
    {
        if( is_array( $this->postCustomBoxes ) && function_exists( 'add_meta_box' ) )
        {
            foreach( $this->postCustomBoxes as $key => $box )
            {
                add_meta_box( $key, $box['label'], $box['callback'], $this->postType, $box['place'], $box['priority'] );
            }
            
            add_action( 'save_post', array( $this, 'postCustomBoxesSave') );
            
        }
    }
    
    public function postCustomBoxesSave( $post )
    {
        $postID     = ( int ) $post;
        $postType   = get_post_type( $post_ID );
        $postStatus = get_post_status( $post_ID );
        
        foreach( $this->postCustomBoxes as $key => $box )
        {
            update_post_meta( $postID, $key, $_POST[ $key ] );
        }
    }
    
    public function postCustomColumnsManage( $post )
    {
    
    }
    
    public function postCustomColumnsAdd( $post )
    {
    
    }
}