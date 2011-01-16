<?php defined('SYSPATH') or die('No direct script access.');

class Page_Title_Exception extends Exception {}

class Page_Title extends Page
{
    public $reverce = FALSE;
    public $separator = ' | ';
    public $prefix;
    public $suffix;
    public $replace_module_segment = FALSE;

    private $_prepend = array();
    private $_append = array();
    private $_title;

    public function  __construct()
    {
	$config = Kohana::config('title');
	$this->reverce = $config->reverce;
	$this->separator = $config->separator;
	$this->prefix = $config->prefix;
	$this->suffix = $config->suffix;
	$this->replace_module_segment = $config->replace_module_segment;
    }

    private function _parse($title = null)
    {
	if(is_null($title)) {
	    $title = $this->_title;
	}
	$this->_render();
	$replace = array(
		    '%sep%'   => $this->separator,
		    '%suf%'   => $this->suffix,
		    '%pref%'  => $this->prefix,
		    '%title%' => $this->_title,
		    '%site%'  => Kohana::config('main')->sitename,
		   );
	$title = str_replace(array_keys($replace), array_values($replace), $title);
	return $this->_title = $title;
    }
    
    public function get()
    {
	if(empty($this->_title)) {
	    $last = self::urlObjects()->getLast();
	    if(!empty($last['title'])) {
		$this->_title = $last['title'];
		if(Kohana::config('main')->parse_title) {
		   $this->_parse($this->_title);
		}
	    }
	    else {
		$this->_render();
	    }
	}
	
	return $this->_title;
    }

    private function _render()
    {
	$title = array();
	$oSegments = self::urlObjects();

	// 1. Получить все сегменты
	// 2. Оставить только их тайтлы
	// 3. Удалить из массива сегмент последней страницы-структуры
	$chain = $oSegments->getList();
	if(!is_array($chain)) {
	    $chain = array();
	}
	$last_structure = $oSegments->getLast('structure');
	foreach($chain as $key=>$val) {
	    if($this->replace_module_segment) {
		if($last_structure['id']==$val['id']) {
		    unset($chain[$key]);
		    continue;
		}
	    }
	    $chain[$key]['name'] = $val['name'];
	}
	unset($last_structure);

	$chain = array_reverse($chain);
	if(is_array($this->_prepend)) {
	    $chain = array_merge($this->_prepend, $chain);
	}
	if(is_array($this->_append)) {
	    $chain = array_merge($chain, $this->_append);
	}
	if($this->reverce) {
	    $chain = array_reverse($chain);
	}
	foreach($chain as $page) {
	    $title[] = is_array($page) ? $page['name'] : $page;
	}

	$this->_title = $this->prefix . implode($this->separator, $title) . $this->suffix;
    }

    public function __toString()
    {
	return $this->get();
    }

    public function append($params)
    {
	$this->_append = array();
	
	if(is_array($params)) {
	    $this->_append = $params;
	}
	else {
	    $this->_append[] = $params;
	}
	return $this;
    }

    public function prepend($params)
    {
	$this->_prepend = array();

	if(is_array($params)) {
	    $this->_prepend = $params;
	}
	else {
	    $this->_prepend[] = $params;
	}
	return $this;
    }
}