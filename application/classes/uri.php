<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 
 * This helpers like KO2 class URI.
 * URI class explode Requset Uri string, and provides access to it segmets
 * @author Dmi3x
 * 
 */

class Uri
{
    /**
     * Stores singletone uri object, installed by uri::instance()
     *
     * @var object uri
     */
    private static $_instance;

    /**
     * Uri string of current object
     * 
     * @var string
     */
    private $_uri;

    /**
     * Exploded Uri of current object by params
     *
     * @example $this->params[1]  # Return first segment of Uri
     *
     * @var array
     */
    public $params;

    /**
     * Current lang
     *
     * @var string
     */
    static $_lang;

    /**
     * @param  mixed  Uri $param (string or Request object)
     */
    function __construct($param)
    {
	$this->set($param);
    }

    /**
     * Always return new uri object
     * 
     * @param  mixed  Uri $param (string or Request object)
     * @return object uri
     */
    public static function object($param)
    {
	return new uri($param);
    }

    /**
     * Return instance of uri
     * Must be used for first, external request
     * 
     * @param  mixed Uri $param = null (string or Request object)
     * @return object uri
     */
    public static function instance($param = null)
    {
	if(empty(self::$_instance)) {
	    self::$_instance = new uri($param);
	}
	return self::$_instance;
    }

    /**
     * Retrieves a specific URI segment
     * Returns $default when the segment does not exist.
     *
     * @param  int    Segment index [1..n]
     * @param  string Segment default value
     * @return string Segment value
     */
    public function segment($index = 1, $default = null)
    {
	$index--;

	$param = $default;
	if(isset($this->params[$index])) {
	    $param = $this->params[$index];
	}

	return $param;
    }

    /**
     * Returns an array of all the URI segments
     * 
     * @param  int   Segment offset
     * @return array All segments
     */
    public function segment_array($offset = null)
    {
	$array = $this->params;
	if(is_int($offset) && $offset>0) {
	    $array = array_slice($array, $offset);
	}
	
	$array = array_diff($array, array(''));

	return $array;
    }

    /**
     * Returns the number of segments
     *
     * @param  int Segment offset
     * @return int Segments count
     */
    public function total_segments($offset = null)
    {
	$array = $this->params;
	if(is_int($offset) && $offset>0) {
	    $array = array_slice($array, $offset);
	}

	return count($this->params);
    }

    /**
     * Returns the entire URI as a string
     *
     * @param  int    Segment offset
     * @param  int    Segment length
     * @return string Uri string
     */
    public function string($offset = 0, $length = null, $withLang = false)
    {
	if(!is_array($this->params)) {
	   return null;
	}

	$params = $this->params;
	
	if($withLang && self::$_lang) {
	    $params = array_merge(array(self::$_lang), $params);
	}

	$array = array_slice($params, $offset, $length);
	if(empty($array)) {
	    return null;
	}
	$string = implode('/', $array);
	
	return $string;
    }

    /**
     * Returns the last segment of an URI
     * @return string
     */
    public function last_segment()
    {
	$array = $this->params;
	return array_pop($array);
    }

    /**
     * Get value of segment by index with offset
     * ! This method not equival $this->segment()
     *
     * @param  int     index of uri segment
     * @param  int     Segment offset
     * @return string  Segment value
     */
    public function get($index, $offset = 0)
    {
	$index--;
	if(is_int($offset) && $offset>0) {
	    $offset--;
	}

	$param = null;
	if(isset($this->params[$index+$offset])) {
	    $param = $this->params[$index+$offset];
	}

	return $param;
    }

    /**
     * Set current object Uri string
     *
     * @param  mixed  Uri $param (string or Request object)
     * @return this
     */
    public function set($param)
    {
	if(is_object($param)) {
	    $this->_uri = $param->uri;
	}
	elseif(is_array($param)) {
	    $this->params = $param;
	    $this->_implode();
	}
	else {
	    $this->_uri = $param;
	}

	$this->_explode();
	
	return $this;
    }

    /**
     * Explode Uri string in array
     */
    private function _explode()
    {
	$this->params = explode('/', $this->_uri);
	
	if(!empty($this->params[0]) && preg_match('|^[a-z]{2}$|i', $this->params[0])) {
	    self::$_lang = array_shift($this->params);
          if (!Kohana::config('langs.list.'.self::$_lang) ){
		self::$_lang = null;
	    }
          
	}
    }

    /**
     * Implode Uri string in array
     */
    private function _implode()
    {
	$this->_uri = implode('/', $this->params );
    }
    
    public static function lang($slash = false)
    {
	if($slash && self::$_lang) {
	    return '/'.self::$_lang;
	}
	return self::$_lang;
    }

    // OMG, forgive me for my sins
    // TODO: Как нибуть обойтись без этого костыля
    public static function getModule($name)
    {
	$oStructure = new Model_Structure;
	return $oStructure->getModuleUrl($name);
    }


#### Aliases

    /**
     * Returns an array of all the URI segments
     * Eq uri::segment_array();
     *
     * @param  int   Segment offset
     * @return array All segments
     */
    public function segments($offset = null)
    {
	return $this->segment_array($offset);
    }

     /**
     * Returns the number of segments
     * Eq uri::total_segments();
     *
     * @param  int Segment offset
     * @return int Segments count
     */
    public function count($offset = null)
    {
	return $this->total_segments($offset);
    }

    public function  __toString()
    {
	$uri = $this->string();
	return  $uri ? $uri : '';
    }
}