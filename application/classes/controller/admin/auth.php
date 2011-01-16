<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Auth extends Controller_Admin
{
    private $_uriSegment = 'auth';
    public $template = 'admin/auth';
    
    public function before()
    {
	parent::before();
	$this->model = new Auth_Cms;
	$this->breadcrumbs = '';
    }

    public function action_index()
    {
	if ($_POST) {
	    $this->model->doAuth($_POST);
	}
	if ($this->model->checkAuth()) {
	    $this->request->redirect($this->url.'/structure');
	}
	$this->template->main = View::factory($this->viewDir.'auth');
    }

    public function action_logout()
    {
	$this->model->logout();
	$this->request->redirect('admin');
    }
}