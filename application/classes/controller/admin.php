<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Admin extends Controller_Common
{     
    public $template = 'admin';
    public $uri;    
    
    private $_uriSegment = 'admin';
    protected $url;
    protected $viewDir;
    protected $breadcrumbs;

    public function before()
    {
	if(Request::$is_ajax) {
	    $this->auto_render = FALSE;
	}
	
	parent::before();
	
	$oAuth = new Auth_Cms;
	
	$oAuth->cookieAuth();
	
	if (!$oAuth->checkAuth() && $this->request->uri!=$this->_uriSegment.'/auth') {
	    $this->request->redirect($this->_uriSegment.'/auth');
	}
      
	$this->uri = uri::instance(Request::instance());

	$this->url = '/'.$this->_uriSegment;
	$this->viewDir = 'admin/'.trim($this->viewDir,'/');

	$this->breadcrumbs = new Page_Breadcrumbs;
	$this->breadcrumbs->showCurrentPage = true;
	$this->breadcrumbs->append(array('name'=>'Structure', 'url'=>$this->url()));
    }

    protected function url()
    {
	return '/'.$this->_uriSegment;
    }

    public function  after()
    {
	if(is_object($this->template)) {
	    $this->template->set('breadcrumbs', $this->breadcrumbs);
	}
	parent::after();
    }
}