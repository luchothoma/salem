<?php
namespace Salem;
/**
 * Dingo Framework Bootstrap Class
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2011
 * @Project Page    http://www.dingoframework.com
 */

class Bootstrap
{
	// Get the requested URL, parse it, then clean it up
	// ---------------------------------------------------------------------------
	public static function get_request_url()
	{	
		// Get the filename of the currently executing script relative to docroot
		$url = (empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '/';
		
		// Get the current script name (eg. /index.php)
		$script_name = (isset($_SERVER['SCRIPT_NAME'])) ? $_SERVER['SCRIPT_NAME'] : $url;
		
		// Parse URL, check for PATH_INFO and ORIG_PATH_INFO server params respectively
		$url = (0 !== stripos($url, $script_name)) ? $url : substr($url, strlen($script_name));
		$url = (empty($_SERVER['PATH_INFO'])) ? $url : $_SERVER['PATH_INFO'];
		$url = (empty($_SERVER['ORIG_PATH_INFO'])) ? $url : $_SERVER['ORIG_PATH_INFO'];
		
		// Check for GET __dingo_page
		$url = (input::get('__dingo_page')) ? input::get('__dingo_page') : $url;
		
		//Tidy up the URL by removing trailing slashes
		$url = (!empty($url)) ? rtrim($url, '/') : '/';
		
		return $url;
	}
	
	
	// Autoload
	// ---------------------------------------------------------------------------
	public static function autoload($controller)
	{
		foreach(array('library','helper') as $type)
		{
			$property = "autoload_$type";
			
			foreach(config::get($property) as $class)
			{
				load::$type($class);
			}
			
			if(!empty($controller->$property) AND is_array($controller->$property))
			{
				foreach($controller->$property as $class)
				{
					load::$type($class);
				}
			}
		}
	}
	
	
	// Run
	// ---------------------------------------------------------------------------
	public static function run()
	{
		define('SALEM_VERSION','0.1');
		
		// Start buffer
		ob_start();
		
		
		// Load core files
		require_once(SYSTEM.'/core/cookie.php');
		require_once(SYSTEM.'/core/config.php');
		//require_once(SYSTEM.'/core/api.php'); TODO
		require_once(SYSTEM.'/core/route.php');
		require_once(SYSTEM.'/core/load.php');
		require_once(SYSTEM.'/core/view.php');
		require_once(SYSTEM.'/core/input.php');
		require_once(SYSTEM.'/core/error.php');
		require_once(APPLICATION.'/'.CONFIG.'/config.php');
		
		
		set_error_handler('Salem\dingo_error');
		set_exception_handler('Salem\dingo_exception');
		
		
		Config::set('system', SYSTEM);
		Config::set('application', APPLICATION);
		Config::set('config', CONFIG);
		
		
		// Load route configuration
		require_once(APPLICATION.'/'.CONFIG.'/route.php');
		
		
		// Get route
		$request_url = self::get_request_url();
		$uri = Route::get($request_url);
		
		// Set current page
		define('CURRENT_PAGE', $request_url);
		
		
		// Load Controller
		//----------------------------------------------------------------------------------------------
		
		// If controller does not exist, give 404 error
		if(!file_exists(APPLICATION.'/'.Config::get('folder_controllers')."/{$uri['controller']}.php"))
		{
			Load::error('general','Controller Not Found','The controller given was not found at: "'. APPLICATION.'/'.Config::get('folder_controllers')."/{$uri['controller']}.php".'"');
		}
		
		
		// Include controller
		require_once(APPLICATION.'/'.Config::get('folder_controllers')."/{$uri['controller']}.php");
		
		// Initialize controller
		//$tmp = '\\Controller\\'.ucfirst($uri['controller']);
		$tmp = '\\Controller\\'.ucfirst(basename($uri['controller']));
		$controller = new $tmp();
		
		
		// Check to see if function exists
		if(!is_callable(array($controller, $uri['method']))) {
		
			Load::error('general','Function Not Found','The function given "'.$uri['method'].'" was not found at: "'. APPLICATION.'/'.Config::get('folder_controllers')."/{$uri['controller']}.php".'"' );

		}
		
		//Load Libraries
		$libraries=Config::get('autoload_library');
		//$libraries[]='db';
		//$libraries[]='session';
		//$libraries[]='auth';
		foreach ($libraries as $lib) {
			load::library($lib);
		}
		
		//Load Helpers
		$helpers=Config::get('autoload_helper');
		foreach ($helpers as $help) {
			load::helper($help);
		}


		// Run Function
		call_user_func_array(array($controller, $uri['method']), $uri['args']);
		
		
		// Display echoed content
		ob_end_flush();
	}
}

