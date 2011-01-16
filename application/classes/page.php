<?php defined('SYSPATH') or die('No direct script access.');

class Page_Exception extends Exception {}

class Page
{
    private static $_instance;

    private $_oUriObjects;
    private $_oTitle;
    private $_oFrontendController;
    private $_oBreadcrumbs;

    private function  __construct() {}
    
    private static function instance()
    {
	if(empty(self::$_instance)) {
	    self::$_instance = new self;
	}
	return self::$_instance;
    }

    public static function urlObjects()
    {
	$obj = self::instance();
	if(empty($obj->_oUriObjects)) {
	    $obj->_oUriObjects = new Page_UrlObjects;
	}
	return $obj->_oUriObjects;
    }

    public static function title()
    {
	$obj = self::instance();
	if(empty($obj->_oTitle)) {
	    $obj->_oTitle = new Page_Title;
	}
	return $obj->_oTitle;
    }

    public static function breadcrumbs()
    {
	$obj = self::instance();
	if(empty($obj->_oBreadcrumbs)) {
	    $obj->_oBreadcrumbs = new Page_Breadcrumbs;
	}
	return $obj->_oBreadcrumbs;
    }

    public static function frontend(Controller_Frontend $object = null)
    {
	$obj = self::instance();
        if($object) {
            $obj->_oFrontendController = $object;
        }
        return $obj->_oFrontendController;
    }

    // use in 404 page
    public static function reset()
    {
	self::$_instance = null;
    }
}