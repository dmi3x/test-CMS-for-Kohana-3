<?php defined('SYSPATH') or die('No direct script access.');

class Auth_Cms
{
    public $sessionKey = 'admin_logged_in';

    public function doAuth($post)
    {
	if ($post['login'] == 'admin' && $post['pass'] == Kohana::config('db_main.admin_pass')) {
	    Session::instance()->set($this->sessionKey, 1);
	    Cookie::set($this->sessionKey, $this->cookieHash());
	    return true;
	}
        return messages::err('Access denied');
    }

    public function logout()
    {
	Session::instance()->delete($this->sessionKey);
	Cookie::delete($this->sessionKey);
	return true;
    }

    public function checkAuth()
    {
	if (Session::instance()->get($this->sessionKey) == 1) {
	    return true;
	}
        return false;
    }

    public function cookieAuth()
    {
	if($this->checkAuth()) {
	    return true;
	}

	if(Cookie::get($this->sessionKey)==$this->cookieHash()) {
	     Session::instance()->set($this->sessionKey, 1);
	     return true;
	}
	return false;
    }

    public function cookieHash()
    {
	return md5(Kohana::config('db_main.admin_pass')) + '-==Sa1t=-';
    }
}