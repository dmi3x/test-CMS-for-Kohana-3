<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Structure extends Controller_Admin
{
    private $_uriSegment = 'structure';
    public  $viewDir = 'structure';
    protected $structureId;

    public function before()
    {
        parent::before();
        $this->model = new Model_Structure;
	if(!Request::$is_ajax) {
	      $structure = $this->model->getTree();
	     // print_r($structure); exit;
	      $tree = new Modules_Options;
	      $treeConfig = $tree->export();
	      $this->template->left = View::factory($this->viewDir.'/left')
					    ->set('structure', $structure)
					    ->set('treeConfig', $treeConfig);
	}
	$this->url = $this->url.'/'.$this->_uriSegment;
	//$this->structureId = Arr::get($_GET, 'structureId');
    }

    public function action_index()
    {
	$list = $this->model->adminGetList();
	$this->template->main = View::factory($this->viewDir.'/index')->set('list', $list);
    }

    // Ajax (popup)
    public function action_add($structureId)
    {
	if (!empty($_POST)) {
	    if ($this->model->add($_POST)) {
		$this->request->redirect($this->url);
	    }
	}
	if(!Request::$is_ajax) {
	    $this->request->redirect($this->url);
	}
	$parentUrl = $this->model->getParentUrl($structureId);
	
        $this->request->response = View::factory($this->viewDir.'/add-popup')
					->set('parentUrl', $parentUrl)
					->set('parentId', $structureId)
					->render();
    }

    public function action_edit($id, $lang = null)
    {
	$lang = $this->model->getLang($lang);
	$item = $this->model->getItemById($id, $lang);
	
	if(empty($item)) {
	    messages::err('Page not exists');
	    $this->request->redirect($this->url);
	}
	$item['module'] = Modules::instance()->get($item['module']);
	$item['parentUrl'] = $this->model->getParentUrl($item['parentId']);

	$parents = $this->model->getAllParents($item['parentId']);
	$parentsForBreadcrumbs = array();
	if(!empty($parents)) {
	    foreach($parents as $val) {
		if(!$val['name']) {
		    break;
		}
		$row['name'] = $val['name'];
		$row['url'] = $this->url.'/edit/'.$val['id'];
		$parentsForBreadcrumbs[] = $row;
	    }
	    $this->breadcrumbs->append($parentsForBreadcrumbs);
	}
		
	$this->template->main = View::factory($this->viewDir.'/edit')->set('item', $item)->set('lang' , $lang);
	if ($_POST) {
	    $_POST['parentId'] = $item['parentId'];
	    if ($this->model->edit($id, $_POST, $lang)) {
		$this->request->redirect($this->url.'/edit/'.$id.'/'.$lang);
	    }
	}
    }

    public function action_delete($id)
    {
        $this->model->delete($id);
	$this->request->redirect($this->url);
    }

    //Ajax methods
    function action_saveTreeStructure()
    {
	if(!empty($_POST['structure'])) {
	    $res1 = $this->model->saveTreeStructure($_POST['structure']);
	    $res2 = $this->model->updateChildrens();
	    if(!$res1 || !$res2) {
		$message = Messages::get_last_message();
		if(!empty($message)) {
		    echo $message['text'];
		    exit();
		}
	    }
	    echo 1;
	}
	exit();
    }
}
