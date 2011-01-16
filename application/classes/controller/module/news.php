<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Module_News extends Controller_Module
{
    function before()
    {
	parent::before();	
	$this->model = new Model_News;

        Page::frontend()->template->test = 'Новости передают привет хедеру!';
    }
    
    function action_index()
    {
        // На странице новостей новости, виджен новостей нам не нужен.
        // Заменим его на виджет погоды, сверху сайдбара
        $this->template->left->delete('news')
                             ->prepend(new Widget_Weather);


        // Внимание! модуль новостей так настроен, что может быть на нескольких страницах...
        // И вот тут вылезает первая проблема: как получить конкретный список новостей в виджете?
        // Пока что только по id страницы... что конечно дико.
        // Проблема будет решена в следующей версии CMS
	$structureId = Page::urlObjects()->getLast('structure', true)->id;
	$pageNum = Arr::get($_GET, 'page', 1);
	$perPage = 10;
	$list = $this->model->getList($pageNum, $perPage, $structureId);

        $options = array (
            'total_items'    => $this->model->countLastList(),
            'items_per_page' => $perPage,
        );

        $pagination = Pagination::factory($options);

	$this->template->main = View::factory('frontend/news/index')
				    ->set('pagination', $pagination)
				    ->set('list', $list);
    }

    //For this action I create Route
    function action_one($alias)
    {
	$uri = Uri::instance();
	$item = $this->model->frontendGetItem($alias);
	if(empty($item)) {
	    return $this->err404();
	}
	$this->template->main = View::factory('frontend/news/one')->set('item', $item);
    }
}