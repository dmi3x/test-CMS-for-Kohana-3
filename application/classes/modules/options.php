<?php defined('SYSPATH') or die('No direct script access.');

class Modules_Options
{
    private $_exportDefaults = array(
	'max_depth' => 0,
	'draggable' => true,
	'icon'	    => 'module',	//default || module || custom
	'edit_mode'  => 'default',	//default || module || linked (структура, модуль, связаный модуль)
	'delete_mode'  => 'deny',	//allow || deny || module
	'valid_children' => 'default',  //auto || not (array) || custom (array)
    );

    private $modules;
    
    public function __construct()
    {
	$this->modules = Modules::instance();
    }

    private function _prepareSettings($module)
    {	
	// Default module config
	if(!empty($module['default'])) {
	    $module['draggable'] = isset($module['draggable']) ? $module['draggable'] : true;
	    $module['max_depth'] = isset($module['max_depth']) ? $module['max_depth'] : 2;
	    $module['icon'] = isset($module['icon']) ? $module['icon'] : 'default';
	    $module['delete_mode'] = isset($module['delete_mode']) ? $module['delete_mode'] : 'allow';
	}

	if(!empty($module['required'])) {
	    $module['draggable'] = isset($module['draggable']) ? $module['draggable'] : false;
	    $module['delete_mode'] = isset($module['delete_mode']) ? $module['delete_mode'] : 'deny';
	}

	if(!empty($module['linked'])) {
	    $module['edit_mode'] = isset($module['edit_mode']) ? $module['edit_mode'] : 'linked';
	    $module['delete_mode'] = isset($module['delete_mode']) ? $module['delete_mode'] : 'deny';
	}

	if(!empty($module['unique'])) {
	    $module['edit_mode'] = isset($module['edit_mode']) ? $module['edit_mode'] : 'module';
	    $module['delete_mode'] = isset($module['delete_mode']) ? $module['delete_mode'] : 'deny';
	}
	
	$module = array_merge($this->_exportDefaults, $module);

	$options['isRequired'] = $module['required'];
	$options['isDefault'] = $module['default'];
	$options['isLinked'] = $module['linked'];
	$options['isUnique'] = $module['unique'];

	$options['edit_mode'] = $module['edit_mode'];
	$options['delete_mode'] = $module['delete_mode'];
	$options['draggable'] = $module['draggable'];
	$options['max_depth'] = $module['max_depth'];

	// ICON
	$icoFolder = '/public/images/admin/modules/';
	switch($module['icon']) {
	    case 'default':
		$options['icon'] = $icoFolder.'page.png';
		break;
	    case 'module':
		$options['icon'] = $icoFolder.$module['alias'].'.png';
		break;
	    default:
		$options['icon'] = $icoFolder.'page.png';
		if(is_array($module['icon']) && isset($module['icon']['custom'])) {
		    $options['icon'] = $icoFolder.$module['icon']['custom'];
		}
	}

	// Valid Children
	if(is_array($module['valid_children'])) {
	    $options['valid_children'] = array();
	    if(key($module['valid_children'])=='not') {
		foreach($this->modules->get_used() as $alias=>$count) {
		    if( ! in_array($alias, $module['valid_children']['not'])) {
			$options['valid_children'][] = $alias;
		    }
		}
	    }
	    if(key($module['valid_children'])=='custom') {
		foreach($this->modules->get_used() as $alias=>$count) {
		    if(in_array($alias, $module['valid_children']['custom'])) {
			$options['valid_children'][] = $alias;
		    }
		}
	    }
	}	
	return $options;
    }

    public function get($moduleName = null)
    {
	$modules = $this->modules->get_modules();
	if($moduleName) {
	    return $this->_prepareSettings($moduleName);
	}
	$options = array();
	foreach($modules as $alias=>$count) {
	    $options[$alias] = $this->_prepareSettings($modules[$alias]);
	}
	return $options;
    }

    public function export()
    {
	return json_encode($this->get());
    }
}