<?php
class KPFilter
{
    private $appInstance;
    
    private function attachFilters()
    {
        add_action( 'rewrite_rules_array', 'KPFilter::permalinksAddRules' );
        
        if( KPConfig::instance()->shouldUseFilterForNavClasses() )
        {
            add_filter( 'nav_menu_css_class', array( $this->appInstance, 'setSelectedNavigationItems' ), 10, 2 );
        }
        
        add_filter( 'body_class', 'KPFilter::bodyClasses' );
        add_filter( 'query_vars', 'KPFilter::permalinksAddVars' );
    }
    
    public function __construct( $app )
    {
        $this->appInstance = $app;
        $this->attachFilters();
    }
    
    public static function bodyClasses( $_classes )
    {
        $classes = KPConfig::instance()->classes();
        
        if( !empty( $classes ) )
        {
            foreach( $classes as $class )
            {
                $_classes[] = $class;
            }
        }
        
        return $_classes;
    }
    
    public static function permalinksAddRules( $_rules )
    {
        $permalinks = KPConfig::instance()->permalinks();
        
        if( is_array( $permalinks ) && array_key_exists( 'rules', $permalinks ) )
        {
            $_rules = $permalinks['rules'] + $_rules;
        }
        
        return $_rules;
    }
    
    public static function permalinksAddVars( $_vars )
    {
        $permalinks = KPConfig::instance()->permalinks();
        
        if( is_array( $permalinks ) && array_key_exists( 'vars', $permalinks ) )
        {
            foreach( $permalinks['vars'] as $var )
            {
                array_push( $_vars, $var );
            }
        }
        
        return $_vars;
    }
}