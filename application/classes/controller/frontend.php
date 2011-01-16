<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend extends Controller_Common
{
    public $template = 'frontend';

    public function  before()
    {
	parent::before();

        // Напрямую к фронтенду аяксу заперещено обращаться
        // Для аякса используйте другие роуты
	if(Request::$is_ajax) {
	    exit('Access deny');
	}

	$this->uri = uri::instance(Request::instance());

	$this->oStructure = new Model_Structure;

	$home = $this->oStructure->getModule('home');
	$title = Arr::get($home, 'name', 'Home');

	Page::breadcrumbs()->prepend(array('name'=> $title, 'url'=>'/'));
    }

    public function action_index()
    {
	// В случае если началось 'зацикливание'
	if($this->request!=Request::instance()) {
	    return $this->err404();
	}
	// Get all url segments
	$segments = $this->uri->segment_array();
	// Check each segment is it a page and add to Page
	$result = $this->oStructure->processUrlSegments($segments);
	
	// Global title config
	Page::title()->append(Kohana::config('db_main.sitename'));
	
	// Url "/404"
	if(Arr::get($segments, 0) == '404') {
	    return $this->err404();
	}

	// Add controller to global object, so we could use it later
	Page::frontend($this);

	// Url exists in Structure (1)
	if($result) {
	    // Generate module uri
	    $other_uri = $this->uri->string(Page::urlObjects()->count());
	    $module_uri = '_modules/'.Page::urlObjects()->getLast(null, true)->module.'/'.trim($other_uri, '/');
	    // Run current module
	    $this->template->content = Request::factory($module_uri)->execute();
	    $item = Page::urlObjects()->getLast();
	    $this->template->keywords = Arr::get($item, 'keywords');
	    $this->template->description = Arr::get($item, 'description');
	}
	// (2,3)
	else {
	    if(Modules::instance()->exists($this->uri->segment(1))) {
		return $this->err404();
	    }
	    $module_uri = '_modules/'.$this->uri->string();
	    try {
		$this->template->content = Request::factory($module_uri)->execute();
	    }
	    catch(ReflectionException $e) {
		return $this->err404();
	    }
	}

	$this->template->title = Page::title()->get();
    }
}