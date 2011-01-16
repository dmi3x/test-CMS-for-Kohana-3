<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Module_Page extends Controller_Module
{
    function action_index()
    {
        $Widget_LastNews = new Widget_News('last');
        // Меняем идентификатор виджета. Чтоб не заменил в сайдбаре другой виджет новостей.
        $Widget_LastNews->alias('Last_News');
        $this->template->left->append($Widget_LastNews);

	$this->template->main = View::factory('frontend/page');
    }
}