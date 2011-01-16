<?php defined('SYSPATH') or die('No direct script access.');

class Moudles_Exception extends Exception {}

class Modules
{
    protected $_config;	    // конфиг

    protected $_used;	    // модули, используемые в структуре

    protected $_modules;    // модули свормированные из конфига

    protected $_options;    // сгруппированные опции из конфига
    
    protected $_reservedUrls;   // список зарезервированныз урлов

    // дефаултные настройки
    private $_defaults = array(  
	'alias'	   => null,  // псевдоним модуля
	'name'	   => null,  // имя модуля
	'default'  => false, // модуль по умолчанию
	'unique'   => false, // можно прикрепить только к 1 странице
	'required' => false, // нельзя удалить, сменить url
	'linked'   => false, // элементы модуля связаны со структурой по id, поэтому его нельзя открепить
	'static'   => false, // этот модуль нужен для резервации url
    );

    private static $_instance; // синглтон

    public static function instance($config = null)
    {
	if(empty(self::$_instance)) {
	     self::$_instance = new self($config);
	}
	return self::$_instance;
    }

    private function __construct($config)
    {
	// Init config
	$this->_config = $config;

	// Set options
	foreach($config as $alias=>$options) {
	    $options['alias'] = $alias;
	    foreach($this->_defaults as $key=>$val) {
		if(empty($options[$key])) {
		    continue;
		}
		$this->_options[$key][$alias] = $alias;
	    }

	    $options = array_merge($this->_defaults, $options);

	    if($options['static']) {
		$url = trim($options['static'], '/');
		$this->_reservedUrls[$url] = $url;
		continue;
	    }

	    $this->_modules[$alias] = $options;
	}
	// Check default module
	if(empty($this->_options['default'])) {
	    $defaultAlias = key($config);
	    $this->_options['default'] = $defaultAlias;
	    $this->_modules[$defaultAlias]['default'] = true;
	}

	// Find and count used modules
	$res = DB::select(array(DB::expr('COUNT(*)'), 'modulesCount'), 'module')
		    ->from('structure')
		    ->group_by('module')
		    ->execute();

	foreach($res as $row) {
	    $this->_used[$row['module']] = $row['modulesCount'];
	}
    }

    // for admin add page
    public function get_list($current_alias = null, $has_children = false, $check_unique = true)
    {
	$liast = array();
	if(!is_null($current_alias)) {
	    $current_module = $this->get($current_alias);
	    if(empty($current_module)) {
		throw new Moudles_Exception('Oops');
	    }
	    if($has_children || $current_module['linked'] || $current_module['required']) {
		$list[$current_alias] = $current_module;
		return $list;
	    }
	}

	foreach($this->_modules as $alias=>$module) {
	    if($current_alias != $alias
	    && $check_unique
	    && ($module['unique'] || $module['required'])
	    && isset($this->_used[$alias])) {
		continue;
	    }
	    $list[$alias] = $module;
	}
	return $list;
    }

    public function exists($alias, $exception = false)
    {
	$r = isset($this->_modules[$alias]);
	if($exception) {
	    if(!$r) {
		throw new Moudles_Exception('Module '.$alias.' not exists');
	    }
	    return true;
	}
	return $r;
    }

    public function get($alias)
    {
	if(!$this->exists($alias)) {
	    return;
	}
	return $this->_modules[$alias];
    }

    public function get_default()
    {
	return is_array($this->_options['default']) ? current($this->_options['default']) : $this->_options['default'];
    }

    public function get_config()
    {
	return $this->_config;
    }

    public function get_used()
    {
	return $this->_used;
    }

    public function get_modules()
    {
	return $this->_modules;
    }

    public function isReservedUrl($url)
    {
	$url = trim($url, '/');
	return isset($this->_reservedUrls[$url]);
    }
}