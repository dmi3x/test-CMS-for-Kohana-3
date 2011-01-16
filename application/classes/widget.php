<?php defined('SYSPATH') or die('No direct script access.');

class Widget_Exception extends Kohana_Exception {  }

abstract class Widget
{
   protected $_alias;

   public function menu($current)
   {
        if(empty($childs)) {
	    return false;
	}	
	$menu = View::factory('menu');
	$menu->current = $current;
	if(!empty($current['childs'])) {
	    $menu->childs = $this->menu($current['childs']);
	}
	return $menu;
   }

   public function __construct()
   {
        $class = get_class($this);
	preg_match('|^[^_]+_(.+)$|Ui', $class, $matches);
	$this->_alias = strtolower($matches[1]);
   }

   public static function factory($name)
   {
       $class = 'Widget_'.$name;
       return new $class;
   }

   public function alias($alias = null)
   {
       if(is_null($alias)) {
	   return $this->_alias;
       }
       $this->_alias = $alias;
       return $this;
   }

   abstract public function render();

   public function  __toString()
   {
	return $this->render();
   }
}