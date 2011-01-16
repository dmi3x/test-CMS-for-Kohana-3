<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Set the production status by the domain.
 */
define('IN_PRODUCTION', (!isset($_SERVER['SERVER_ADDR']) || ($_SERVER['SERVER_ADDR'] !== '127.0.0.1')));

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
	'index_file' => FALSE,
	'profiling'  => ! IN_PRODUCTION,
	'caching'    => IN_PRODUCTION
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */

Kohana::modules(array(
	// 'auth'       => MODPATH.'auth',       // Basic authentication
	 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   => MODPATH.'database',   // Database access
	 'image'      => MODPATH.'image',      // Image manipulation
	// 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'oauth'      => MODPATH.'oauth',      // OAuth authentication
	 'pagination' => MODPATH.'pagination', // Paging of results
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	 'mail'	      => MODPATH.'mail', // Swift Mailer for KO3
	));


//Load config from DataBase
Kohana::$config->attach(new Kohana_Config_Database, FALSE);

if(IN_PRODUCTION) {
    Database::instance('default', Kohana::config('database.remote'));
}

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
 
if ( ! Route::cache())
{
	// Admin
        Route::set('admin', 'admin(/<controller>(/<action>(/<param1>(/<param2>(/<etc>)))))', array('etc' => '.*'))
	       ->defaults(array('directory'  => 'admin', 'controller' => 'structure', 'action' => 'index'));

	// Widgets (for ajax)
	Route::set('widget', 'widget/<widget>(/<etc>)', array('etc' => '.*'))->defaults(array('controller' => 'widget'));

	// Modules
	// --	News
	Route::set('one_news', '_modules/news/<alias>')->defaults(array('controller' => 'news', 'directory' => 'module', 'action' => 'one'));
	Route::set('news', '_modules/news/page/<num>')->defaults(array('controller' => 'news', 'directory' => 'module'));

	// --	Default
	Route::set('modules', '_modules(/<controller>(/<etc>))', array('etc' => '.*'))->defaults(array('directory' => 'module'));

	// Default
	Route::set('default', '(<page>)', array('page' => '.*'))->defaults(array('controller' => 'frontend'));

	if(IN_PRODUCTION) {
	    Route::cache(TRUE);
	}
}

if ( ! defined('SUPPRESS_REQUEST')) 
{
	$request = Request::instance();

	try {
	    $request->execute();
	}

	catch (Exception $e) {
	    if(!IN_PRODUCTION) {
		throw $e;
		exit;
	    }
	    // Log the error
	    Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));
	    $request->response = View::factory('frontend/error')->render();
	}
	echo $request->send_headers()->response;
}