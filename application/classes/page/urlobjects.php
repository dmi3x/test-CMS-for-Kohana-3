<?php defined('SYSPATH') or die('No direct script access.');

class Page_UrlObjects extends Page
{
    private $_depth = 0;

    private $_urlObjects;

    private $_groups;

    private $_groupLevel;

    public function  __construct() {}

    public function add($urlObjects, $groupName)
    {
	if(!is_array($urlObjects) || empty($urlObjects) || !is_string($groupName)) {
	    throw new Page_Exception('Incorrect param');
	}

	if(!empty($urlObjects['id'])) {
	    $urlObjects = array($urlObjects);
	}

	$this->_groupLevel[$groupName] = $this->_depth + 1;

	foreach($urlObjects as $val) {
	    $this->_depth++;
	    $this->_urlObjects[$this->_depth] = $val;
	    $this->_groups[$groupName][$this->_depth] =& $this->_urlObjects[$this->_depth];
	}

	return $this;
    }

    public function getLast($groupName = null, $asObject = false)
    {
	if(!$this->count()) {
	    return null;
	}
	if(!is_null($groupName)) {
	    $last = end($this->_groups[$groupName]);
	    reset($last);
	}
	else {
	    $last = end($this->_urlObjects);
	    reset($this->_urlObjects);
	}
	if($asObject) {
	    $last = (object)$last;
	}
	return $last;
    }

    public function getParent()
    {	
	$parent = prev(end($this->_urlObjects));
	reset($this->_urlObjects);
	return $parent;
    }

    public function getList($groupName = null)
    {
	if(!is_null($groupName)) {
	    if(!$this->groupExists($groupName)) {
		return null;
	    }
	    return $this->_groups[$groupName];
	}
	return $this->_urlObjects;
    }

    public function getDepth($groupName = null)
    {
	if(!is_null($groupName)) {
	    return $this->_groupLevel[$groupName];
	}
	return $this->_depth;
    }

    public function count($groupName = null)
    {
	if(!is_null($groupName)) {
	    if(!$this->groupExists($groupName)) {
		return 0;
	    }
	    return count($this->_groups[$groupName]);
	}
	return count($this->_urlObjects);
    }

    public function groupExists($groupName)
    {
        return isset($this->_groups[$groupName]);
    }

    public function getListByField($groupName, $field)
    {
	if(!is_null($groupName)) {
	    $list = $this->_groups[$groupName];
	}
	else {
	    $list = $this->_urlObjects;
	}
	foreach($list as $val) {
	    $result[] = $val[$field];
	}
	return $result;
    }
}