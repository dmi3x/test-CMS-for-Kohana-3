<?php defined('SYSPATH') or die('No direct script access.');

class ArrIndex
{
    private $_arr;
    private $_index;

    public function  __construct( & $arr)
    {
	$this->_arr = & $arr;
    }

    public static function obj( & $arr)
    {
	return new self($arr);
    }

    public static function get( & $arr, $args)
    {
	if(!is_array($args)) {
	    $args = func_get_args();
	    unset($args[0]);
	}
	return self::obj($arr)->get_index($args);
    }

    public function get_index($args)
    {
	if(!is_array($args)) {
	    $args = func_get_args();
	}
	$id = $this->_generate_id($args);

	if(empty($this->_index[$id])) {
	    $this->_add($args);
	}
	return $this->_index[$id];
    }

    private function _add($fields)
    {
	$id = $this->_generate_id($fields);
	$this->_index[$id] = array();
	if(!is_array($fields)) {
	    $fields = array($fields);
	}

	foreach($this->_arr as $key=>$row) {
	    $link =& $this->_index[$id];
	    foreach($fields as $field) {
		if(!isset($link[$row[$field]])) {
		    $link[$row[$field]] = array();
		}
		$link =& $link[$row[$field]];
	    }
	    $link = $this->_arr[$key];
	}

	return $this;
    }

    private function _generate_id($fields)
    {
	if(is_array($fields)) {
	    return implode('.', $fields);
	}
	return $fields;
    }
}