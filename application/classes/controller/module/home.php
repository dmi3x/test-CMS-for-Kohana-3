<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Module_Home extends Controller_Module
{
    public $template = 'frontend/one_column';

    public function action_index()
    {
	$this->template->main = View::factory('frontend/home');
    }
}