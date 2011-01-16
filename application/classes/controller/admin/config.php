<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Config extends Controller_Admin
{
    private $_uriSegment = 'config';
    protected $viewDir = 'config';

    public $model;

    public function  before()
    {
	parent::before();
	$this->url = $this->url.'/'.$this->_uriSegment;
	$this->model = new Model_Config;
    }

    public function action_index()
    {
      if ($_POST)
      {
            $this->model->save($_POST);
            $this->request->redirect('/admin/config'); 
      }
      $conf['db_main'] = $this->model->getGroup('db_main');
      $conf['db_labels'] = $this->model->getGroup('db_labels');
	$this->template->main = View::factory('admin/config/index')->set('conf', $conf);
    }

}
