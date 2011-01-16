<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common extends Controller_Template
{
    public function before()
    {
	parent::before();

	if($this->request!==Request::instance()) {
	    $this->request->is_internal = true;
	}
	else {
	    $this->request->is_internal = false;
	    Cookie::$expiration = 3600*24*30;
	}
	Modules::instance(Kohana::config('modules'));
    }

    public function err404()
    {
	Page::reset();

	$segments = uri::instance(Request::instance())->segment_array();
	$oStructure = new Model_Structure;
	$oStructure->processUrlSegments(array('404'));

	$page = Page::urlObjects()->getLast();
	$parents = null;
	if(empty($page)) {
	    $parents = array('id'=>1, 'name'=>'Page not found', 'text'=> null);
	}

	Page::title()->append(Kohana::config('db_main')->sitename);
	Request::instance()->status = 404;
	
	//TODO: check  Page[text] if in db not exists page 404
	$view404 = View::factory('frontend/404')->set('text', $page['text']);
	$viewOneColumn = View::factory('frontend/one_column');
	
	if($this->request->is_internal && $this->request->uri!='404') {
	   // нужно уничтожить всю инфу модуля из $this->template и вернуть чисто шиблон one_column
	    $this->template = $viewOneColumn;
	    $this->template->main = $view404;
	}
	else {
	    $this->template->content = $viewOneColumn; 
	    $this->template->content->main = $view404;
	}
	$this->template->title   = Page::title();	
    }
}