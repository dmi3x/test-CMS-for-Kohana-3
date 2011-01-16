<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Widget extends Controller
{
    public function action_index($widgetName)
    {
	$class = 'Widget_'.$widgetName;
	try {
	    $oWidget = new $class;
	    echo $oWidget->render();
	}
	catch (Exception $e) {
	    throw $e;
	    exit;
	}
    }
}