<?php defined('SYSPATH') or die('No direct script access.');

class Sort
{
    public $sortKey = 'sort';
    public $orderKey = 'order';
    public $pageKey = 'page';
    public $classPrefix = 'order_';
    public $default = array();

    public function obj()
    {
	return new self;
    }

    public function query($setSort, $defaultOrder = 'desc')
    {
	$params['sort'] = $setSort;

	if( ! Arr::get($_GET, $this->sortKey) && Arr::get($this->default, 'sort')==$setSort) {
	    $params['order'] = (Arr::get($this->default, 'order', $defaultOrder)=='desc') ? null : 'desc';
	}
	// Если текущая сортировка не совпадает с новой, то сбрасываем пагинацию
	elseif(Arr::get($_GET, $this->sortKey) != $setSort) {
	    $params['page'] = NULL;
	    $params['order'] = $defaultOrder;
	}
	else {
	    $params['order'] = (Arr::get($_GET, $this->orderKey)=='desc') ? null : 'desc';
	}
	
	return '/' . uri::instance()->string() . Html::entities(URL::query($params));
    }

    public function getClass($sortKey)
    {
	if( ! Arr::get($_GET, $this->sortKey) && $sortKey==Arr::get($this->default, 'sort')) {
	    $order = (Arr::get($this->default, 'order')=='desc') ? 'desc' : 'asc';
	    return $this->classPrefix . $order;
	}

	if(Arr::get($_GET, $this->sortKey) != $sortKey) {
	    return;
	}
	
	$currentOrder = Arr::get($_GET, $this->orderKey);
	$order = ($currentOrder=='desc') ? 'desc' : 'asc';
	return $this->classPrefix . $order;
    }
}