<?php
class KPApplication extends KPApplicationBase
{
    protected function setConfiguration()
    {
        $kapow = $this;
        require_once KP_PATH . DS . 'configuration.php';
    }

    protected function setMenus()
    {
        return require_once KP_PATH . DS . 'menus.php';
    }

    protected function setPermalinks()
    {
        return require_once KP_PATH . DS . 'permalinks.php';
    }

    protected function setSizes()
    {
        return require_once KP_PATH . DS . 'sizes.php';
    }

    protected function setSupports()
    {
        return require_once KP_PATH . DS . 'supports.php';
    }

    protected function setSidebars()
    {
        return require_once KP_PATH . DS . 'sidebars.php';
    }

    protected function setStylesheets()
    {
        return array();
        //return require_once KP_PATH . DS . 'stylesheets.php';
    }

    protected function setScripts()
    {
        return array();
        //return require_once KP_PATH . DS . 'scripts.php';
    }

    public function setSelectedNavigationItems( $classes = array(), $item )
    {
        return $classes;
    }
}