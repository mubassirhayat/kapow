<?php

class KPApplicationBase 
{
    private $templates   = array();
    private $menus       = array();
    private $sizes       = array();
    private $supports    = array();
    private $stylesheets = array();
    private $scripts     = array();
    private $permalinks  = array();
    private $KPFilters   = null;
    private $KPHook      = null;
    private $KPConfig    = null;
    private $KPHelper    = null;
    
    protected $postTypes = array();
    protected $widgets   = array();
    protected $plugins   = array();
    
    public $config       = null;
    public $helper       = null;

    protected function setConfiguration(){}
    protected function setPermalinks(){ return array(); }
    protected function setMenus(){ return array(); }
    protected function setSizes(){ return array(); }
    protected function setSupports(){ return array(); }
    protected function setSidebars(){ return array(); }
    protected function setStylesheets(){ return array(); }
    protected function setScripts(){ return array(); }
    public function setSelectedNavigationItems( $classes = array(), $item ){ return $classes; }

    public function dispatch()
    {
        $this->KPConfig = KPConfig::instance();
        $this->KPHelper = KPHelper::instance();
        $this->KPHook   = KPHook::instance();
        
        // Alias
        $this->config = $this->KPConfig;
        $this->helper = $this->KPHelper;
        
        $this->menus       = $this->setMenus();
        $this->sizes       = $this->setSizes();
        $this->supports    = $this->setSupports();
        $this->sidebars    = $this->setSidebars();
        $this->stylesheets = $this->setStylesheets();
        $this->scripts     = $this->setScripts();
        $this->permalinks  = $this->setPermalinks();

        $this->setConfiguration();

        if( $this->KPConfig->shouldAutoLoadPostTypes() )
        {
            $this->postTypes = @array_merge( 
                glob( KP_POST_TYPE . '/*PostType.php' ),
                glob( KP_APP_POST_TYPE . '/*PostType.php' )
            );
        }

        if( !empty( $this->postTypes ) )
        {
            $this->postTypes = $this->KPHook->registerPostTypes( $this->postTypes );
        }

        $this->KPHook->registerNavMenus( $this->menus );
        $this->KPHook->registerSidebars( $this->sidebars );
        $this->KPHook->addImageSizes( $this->sizes );
        $this->KPHook->addThemeSupports( $this->supports );
        $this->KPHook->addStylesheets( $this->stylesheets );
        $this->KPHook->addScripts( $this->scripts );
        $this->KPHook->addPermalinks( $this->permalinks );
        
        $this->KPFilter = new KPFilter( $this );
    }
    
    public function __construct()
    {
        $this->dispatch();
    }

    public function __call( $name, $arguments )
    {
        if( method_exists( $this, $name ) )
        {
            return call_user_func_array( array( $this, $name ), $arguments );
        }
        else if( method_exists( $this->helper, $name ) )
        {
            return call_user_func_array( array( $this->helper, $name ), $arguments );
        }
    }
}