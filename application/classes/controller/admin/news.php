<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_News extends Controller_Admin
{
    private $_uriSegment = 'news';
    protected $viewDir = 'news';

    protected $structureId;

    public function before()
    {
        parent::before();
	$this->template->left = View::factory($this->viewDir.'/left')->bind('structureId', $this->structureId);
        $this->model = new Model_News;
	$this->url = $this->url.'/'.$this->_uriSegment;
    }

    public function action_index($structureId = null)
    {
	if(empty($structureId)) {
	    messages::err('News require structure parent');
	    $this->request->redirect(parent::url());
	}
	$this->structureId = $structureId;

	$oStructure = new Model_Structure;
	$parentUrl = $oStructure->getParentUrl($structureId);

	$pageNum = Arr::get($_GET, 'page', 1);
	$perPage = 10;
	$list = $this->model->getList($pageNum, $perPage, $structureId);
	
        $options = array (
            'total_items'    => $this->model->countLastList(),
            'items_per_page' => $perPage,
        );

        $pagination = Pagination::factory($options);
	
	$this->template->main = View::factory($this->viewDir.'/index')
				    ->set('list', $list)
				    ->set('parentUrl', $parentUrl)
				    ->set('structureId', $structureId)
				    ->set('pagination', $pagination);
    }

    public function action_add($structureId)
    {
	$this->structureId = $structureId;
	if (!empty($_POST)) {
	    if ($this->model->add($_POST, $structureId)) {
		$this->request->redirect($this->url.'/index/'.$structureId);
	    }
	}
	$oStructure = new Model_Structure;
	$parentUrl = $oStructure->getParentUrl($structureId);
        $this->template->main = View::factory($this->viewDir.'/add')
				    ->set('structureId', $structureId)
				    ->set('parentUrl', $parentUrl);
    }

    public function action_edit($id)
    {
	if (!empty($_POST)) {
	    if ($this->model->edit($id, $_POST)) {
		$this->request->redirect($this->url.'/edit/'.$id);
	    }
	}
	$item = $this->model->getItemById($id);
	if(empty($item)) {
	    messages::err('News not found');
	    $this->request->redirect($this->url);
	}
	$this->structureId = $item['structureId'];
	$oStructure = new Model_Structure();
	$item['parentUrl'] = $oStructure->getParentUrl($item['structureId']);

	$this->template->main = View::factory($this->viewDir.'/edit')->set('item', $item);
    }

    public function action_delete($id, $structureId)
    {
	$this->model->delete($id);
	$this->request->redirect($this->url.'/index/'.$structureId);
    }

    public function  after()
    {
	if(!empty($this->structureId)) {
	    $this->breadcrumbs->append(array('name'=>'News', 'url'=>$this->url.'/index/'.$this->structureId));
	}
	parent::after();
    }
}