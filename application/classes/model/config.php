<?php defined('SYSPATH') or die('No direct script access.');

class Model_Config extends Model_Base
{
    public $table = 'config';

    public function getGroup($group)
    {
        return DB::select()->from($this->table)
                           ->where('group_name', '=', $group)
                           ->execute()
                           ->as_array();
    }
    
    
    public function save($post)
    {
	  foreach($post['db_main'] as $key => $val)
	  {
		Kohana::config("db_main")->$key = $val;
	  }
	  return messages::ok('Changes was saved');
    }    
}