<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Home extends Controller_Admin
{
    protected $_uriSegment = 'home';
    protected $viewDir = 'home';

    public $oTabs;

    public function  before()
    {
	parent::before();

	$oStructure = new Model_Structure;
	$item = $oStructure->getModule('home');
	$this->structureId = $item['id'];

	if(!Request::$is_ajax) {
	    $this->url = $this->url.'/'.$this->_uriSegment;
	    $this->template->left = '';
	    $this->breadcrumbs->append(array('name'=>'Home', 'url'=>$this->url));
	}
    }

    public function action_index()
    {
	$this->template->main = View::factory($this->viewDir.'/index')->set('structureId', $this->structureId);
    }
}
