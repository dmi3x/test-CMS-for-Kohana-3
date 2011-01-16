<?php defined('SYSPATH') or die('No direct script access.');

class Page_Breadcrumbs extends Page
{
    public  $showCurrentPage = FALSE;
    private $_prepend= array();
    private $_append = array();
    private $_viewName = 'breadcrumbs';

    public function  __construct($urlObjects = null)
    {
	if(!is_null($urlObjects)) {
	    $this->prepend($urlObjects);
	}
    }

    // получить цепочку ввиде массива
    public function getArray()
    {
	if(self::urlObjects()->count()) {
	    $last = self::urlObjects()->getLast();
	    $urlObjects = self::urlObjects()->getList();
	    if(empty($last['alias'])) {
		return null;
	    }
	    if(!$this->showCurrentPage) {
		array_pop($urlObjects);
	    }
	    if(is_array($this->_prepend) && !empty($this->_prepend)) {
		$urlObjects = array_merge($this->_prepend, $urlObjects);
	    }
	    if(is_array($this->_append) && !empty($this->_append)) {
		$urlObjects = array_merge($urlObjects, $this->_append);
	    }
	}
	else {
	    $urlObjects = array_merge($this->_prepend, $this->_append);
	    if(empty($urlObjects)) {
		return false;
	    }
	    $last = current(end($urlObjects));
	    reset($urlObjects);
	    if(empty($last['alias'])) {
		return null;
	    }
	    if(!$this->showCurrentPage) {
		array_pop($urlObjects);
	    }
	}

	$list = $parents = array();
	foreach($urlObjects as $val) {
	    $item = array();
	    if(!empty($val['url'])) {
		$item['url'] = $val['url'];
	    }
	    elseif(!empty($val['alias'])) {
		$parents[] = $val['alias'];
		$item['url'] = implode('/', $parents);
	    }
	    if(isset($item['url'])) {
		$item['url'] = '/'.trim($item['url'], '/');
	    }
	    $item['name'] = $val['name'];
	    $list[] = $item;
	}

	return $list;
    }

    public function render($oView = null)
    {
	$list = $this->getArray();
	if($oView instanceof View) {
	    return $oView->set('list')->set('list', $list);
	}
        return View::factory($this->_viewName)->set('list', $list);
    }

    public function  __toString()
    {
	echo $this->render();
	return '';
    }

    public function prepend($prepend)
    {
	if(empty($prepend) || !is_array($prepend)) {
	    return $this;
	}
	if(!is_numeric(key($prepend))) {
	    $prepend = array($prepend);
	}
    	if(is_array($this->_prepend)) {
	    $this->_prepend = array_merge($prepend, $this->_prepend);
	}
	else {
	    $this->_prepend = $prepend;
	}
	return $this;
    }

    public function append($append)
    {
	if(empty($append) || !is_array($append)) {
	    return $this;
	}
	if(!is_numeric(key($append))) {
	    $append = array($append);
	}
    	if(is_array($this->_append)) {
	    $this->_append = array_merge($this->_append, $append);
	}
	else {
	    $this->_append = $append;
	}
	return $this;
    }

    public function setFilename($filename)
    {
	$this->_viewName = $filename;
    }
}