<?php defined('SYSPATH') or die('No direct script access.');

class Sidebar_Exception extends Kohana_Exception {  }

class Sidebar
{
    private $_widgets;

    public function __construct($args = null)
    {
	if(!is_null($args) && !is_array($args)) {
	    $args = func_get_args();
	}
	if(empty($args)) {
	    return;
	}
	$this->append($args);
    }
   
    public static function obj($args = null)
    {
	if(!is_null($args) && !is_array($args)) {
	    $args = func_get_args();
	}
	return new self($args);
    }

    private function _load_widget($widget)
    {
	if(is_string($widget)) {
	    $name = 'Widget_'.$widget;
    	    return new $name();
	}

	if($widget instanceof Widget) {
	    return $widget;
	}

	if(is_array($widget)) {
	    foreach($widget as $val) {
		$widgets[] = $this->_load_widget($val);
	    }
	    return $widgets;
	}
	
	throw new Sidebar_Exception('Unexpected type of param');
    }

    public function append($widget)
    {
	if(!is_array($widget)) {
	    $widget = func_get_args();
	}

	$widget = $this->_load_widget($widget);
	
	if(is_array($widget)) {
	    foreach($widget as $val) {
		$this->_append_one($val);
	    }
	}
	else {
	    $this->_append_one($widget);
	}
	
	return $this;
    }

    private function _append_one($widget)
    {
	if($this->is($widget->alias())) {
	    $this->delete($widget->alias());
	}
	$this->_widgets[$widget->alias()] = $widget;
	return $this;
    }

    public function prepend($widget)
    {
	$widget = $this->_load_widget($widget);

	if(is_array($widget)) {
	    $widget = array_reverse($widget);
	    foreach($widget as $val) {
		$this->_prepend_one($val);
	    }
	}
	else {
	    $this->_prepend_one($widget);
	}

	return $this;
    }

    private function _prepend_one($widget)
    {
	if($this->is($widget->alias())) {
	    $this->delete($widget->alias());
	}
	$this->_widgets = array_merge(array($widget->alias() => $widget), $this->_widgets);
	return $this;
    }

    public function params($name, $params)
    {
	$this->get($name)->params($params);
	return $this;
    }

    public function get($name)
    {
	return $this->_widget[$name];
    }

    public function is($name)
    {
	return isset($this->_widgets[$name]);
    }

    public function up($name)
    {
	reset($this->_widgets);
	if(key($this->_widgets)==$name) {
	    return $this;
	}
	$new_arr = array();
	foreach ($this->_widgets as $key => $val) {
	    $new_arr[$key] = $val;
	    if ($key == $name) {
		  unset($new_arr[$prev_key]);
		  $new_arr[$prev_key] = $prev_val;
	    }
	    $prev_key = $key;
	    $prev_val = $val;
	}
	$this->_widgets = $new_arr;
	return $this;
    }

    public function down($name)
    {
	end($this->_widgets);
	if(key($this->_widgets)==$name) {
	    return $this;
	}
	$new_arr = array();
	$is_first = 1;
	foreach ($this->_widgets as $key => $val) {
	    $new_arr[$key] = $val;
	    if (!$is_first && $prev_key == $name) {
		  unset($new_arr[$prev_key]);
		  $new_arr[$prev_key] = $prev_val;
	    }
	    $is_first = 0;
	    $prev_key = $key;
	    $prev_val = $val;
	}
	$this->_widgets = $new_arr;
	return $this;
    }

    public function delete($name = null)
    {
	if(is_null($name)) {
	    $this->_widgets = null;
	}
	else {
	    if(!isset($this->_widgets[$name])) {
		throw new WidgetBox_Exception('Widget "'.$name.'" not found');
	    }
	    unset($this->_widgets[$name]);
	}
	return $this;
    }

    // Alias delete
    public function clear()
    {
	return $this->delete();
    }

    public function render()
    {
	if(empty($this->_widgets)) {
	    return '';
	}
	$widget = '';
	foreach($this->_widgets as $val) {
	    $widget .= $val->render();
	}
	return $widget;
    }

    public function __toString()
    {
	try
	{
	    return $this->render();
	}
	catch (Exception $e)
	{
	    // Display the exception message
	    Kohana::exception_handler($e);

	    return '';
	}
    }
}