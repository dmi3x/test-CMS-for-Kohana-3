<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'page'	    =>   array(
	    'name'	=> 'Страница',
	    'default'	=> true,
	    'valid_children' => array('not' => array('home')),
	),
	'home'	    =>   array(
	    'name'	=> 'Главная',
	    'required'	=> true,
	    'draggable' => true,
	),
	'err404'    =>   array(
	    'name'	=> 'Страница не найдена',
	    'required'	=> true,
	    'icon'	=> array('custom'=>'404.gif'),
	),
    // News
	'news'  =>   array(
	    'name'	=> 'Новости',
	    'linked'	=> true,
	),
    // Reserved urls
	'admin'	    =>   array(
	    'name'	=> 'Admin',
	    'static'	=> '/admin',
	),
);
