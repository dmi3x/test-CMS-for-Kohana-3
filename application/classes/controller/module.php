<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Module extends Controller_Common
{
    public $template = 'frontend/two_columns';

    public $uri;

    public function before()
    {
	parent::before();
	/**
	 * This is protection of direct (external) request to this controller
	 */
	if($this->request == Request::instance() && !Request::$is_ajax) {
	    $this->request->redirect('/');
	}
	
	$params = uri::object($this->request->uri)->string(2);
	$this->uri = uri::object($params);

	if( ! Request::$is_ajax) {
	    $page = Page::urlObjects()->getLast();
	    if(!empty($page)) {
		View::set_global('currentPage', $page);
	    }
	}

        $this->template->left = new Sidebar( new Widget_News, new Widget_Photos);
    }
}