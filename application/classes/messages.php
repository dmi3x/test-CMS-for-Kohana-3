<?php defined('SYSPATH') OR die('No direct access allowed.');

class Messages
{
    private static $messages = NULL;
    private static $last_message = NULL;
    
    public static function err($text)
    {
	self::$last_message = array('text'=>$text, 'ok'=>false);
        self::$messages[] = self::$last_message;
	self::save();
        return false;
    }

    public static function ok($text)
    {
        self::$last_message = array('text'=>$text, 'ok'=>true);
        self::$messages[] = self::$last_message;
	self::save();
        return true;
    }
    
    public static function valid_err($errors)
    {
        $errorsmess = '';
        foreach ($errors as $key=>$val)
        {
          $errorsmess.= $val.'<br/>';  
        }
        self::$last_message = array('text'=>$errorsmess, 'ok'=>false);
        self::$messages[] = self::$last_message;
    	self::save();
        return false;
    }    

    public static function save()
    {
	if(Request::$is_ajax) {
	    return;
	}
        Session::instance()->set('messages', self::$messages);
        Session::instance()->set('last_message', self::$last_message);
    }

    public static function get_last_message()
    {
	if(Request::$is_ajax) {
	    return self::$last_message;;
	}
	$msg = Session::instance()->get('last_message');
        if($msg){
            Session::instance()->delete('last_message');
            return $msg;
        }
        return self::$last_message;
    }

    public static function get_messages()
    {
	if(Request::$is_ajax) {
	    return self::$messages;
	}
	$msg = Session::instance()->get('messages');
        if($msg) {
            Session::instance()->delete('messages');
            return $msg;
        }
        return self::$messages;
    }

    public static function clear()
    {
	self::$messages = NULL;
	self::$last_message = NULL;
	self::save();
    }

    public static function clear_last()
    {
	if(!empty(self::$messages)) {
	    array_pop(self::$messages);
	    self::$last_message = end(self::$messages);
	}
	self::save();
    }
}