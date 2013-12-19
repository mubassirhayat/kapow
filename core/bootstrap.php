<?php
define( 'DS'           , '/' );
define( 'KP_PATH'      , substr( dirname( __FILE__ ), 0, strlen( dirname( __FILE__ ) ) - 5 ) );
define( 'KP_CORE'      , KP_PATH . DS . 'core' );
define( 'KP_CLASS'     , KP_CORE . DS . 'class' );
define( 'KP_VENDOR'    , KP_CORE . DS . 'vendor' );
define( 'KP_ASSETS'    , KP_CORE . DS . 'assets' );
define( 'KP_PLUGIN'    , KP_VENDOR . DS . 'plugin' );
define( 'KP_POST_TYPE' , KP_VENDOR . DS . 'post-type' );
define( 'KP_WIDGET'    , KP_VENDOR . DS . 'widget' );

define( 'KP_APP'           , get_stylesheet_directory() );
define( 'KP_APP_VENDOR'    , KP_APP . DS . 'assets' . DS . 'vendor' );
define( 'KP_APP_PLUGIN'    , KP_APP_VENDOR . DS . 'plugin' );
define( 'KP_APP_POST_TYPE' , KP_APP_VENDOR . DS . 'post-type' );
define( 'KP_APP_WIDGET'    , KP_APP_VENDOR . DS . 'widget' );

define( 'D_THEME' , get_template_directory_uri() );

include KP_CLASS . DS . 'Exception.php';
include KP_CLASS . DS . 'Config.php';
include KP_CLASS . DS . 'Db.php';
include KP_CLASS . DS . 'Lang.php';
include KP_CLASS . DS . 'PostType.php';
include KP_CLASS . DS . 'Image.php';
include KP_CLASS . DS . 'Filter.php';
include KP_CLASS . DS . 'Wp.php';
include KP_CLASS . DS . 'Widget.php';
include KP_CLASS . DS . 'Sidebar.php';
include KP_CLASS . DS . 'String.php';
include KP_CLASS . DS . 'Mail.php';
include KP_CLASS . DS . 'Post.php';
include KP_CLASS . DS . 'Request.php';
include KP_CLASS . DS . 'Server.php';
include KP_CLASS . DS . 'Helper.php';
include KP_CLASS . DS . 'Hook.php';
include KP_CLASS . DS . 'ApplicationBase.php';
include KP_CLASS . DS . 'Application.php';
include KP_CORE . DS . 'functions.php';

$errors = false;
$kapow  = new KPApplication;

define( 'D_ASSETS' , D_THEME . DS . $kapow->config->dirNameAssets() );
define( 'D_IMAGES' , D_ASSETS . DS . $kapow->config->dirNameImages() );
define( 'D_SCRIPT' , D_ASSETS . DS . $kapow->config->dirNameScripts() );
define( 'D_STYLE'  , D_ASSETS . DS . $kapow->config->dirNameStyles() );
define( 'D_XHR'    , D_ASSETS . DS . $kapow->config->dirNameXhr() );
