<?php

namespace Salem;
use Salem\View;
/**
 * Dingo Framework Router Class
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/routes
 */

class Route {
	
	private static $route = array();
	private static $current = array();
	private static $pattern = array(
		'int'=>'/^([0-9]+)$/',
		'numeric'=>'/^([0-9\.]+)$/',
		'alpha'=>'/^([a-zA-Z]+)$/',
		'alpha-int'=>'/^([a-zA-Z0-9]+)$/',
		'alpha-numeric'=>'/^([a-zA-Z0-9\.]+)$/',
		'words'=>'/^([_a-zA-Z0-9\.\- ]+)$/',
		'any'=>'/^(.*?)$/',
		'extension'=>'/^([a-zA-Z]+)\.([a-zA-Z]+)$/'
	);
	
	
	// Validate
	// ---------------------------------------------------------------------------
	public static function valid($r) {
		
		foreach($r['segments'] as $segment) {
			
			if(!preg_match(ALLOWED_CHARS,$segment)) {
				
				return FALSE;
			
			}
		
		}
		
		return TRUE;
		
	}
	
	
	// Pattern
	// ---------------------------------------------------------------------------
	public static function pattern($name, $regex) {
	
		self::$pattern[$name] = $regex;
	
	}
	
	
	// Add
	// ---------------------------------------------------------------------------
	public static function add($routes) {
		
		foreach($routes as $key=>$val) {
		
			self::$route[$key] = explode('.', $val);
		
		}
		
	}
	
	
	// Get
	// ---------------------------------------------------------------------------
	public static function get($url) {
	
		$controller = false;
		$method = false;
		
		$url = preg_replace('/^(\/)/','',$url); // Remove beginning slash
		$segments = explode('/', $url);         // Split into segments
		
		
		// 1) Default route
		if(empty($segments[0])) {
			
			// Get
			if(isset(self::$route['/'])) {
			
				return array('controller'=>self::$route['/'][0], 'method'=>self::$route['/'][1], 'args'=>array());
			
			}
			
			// No default route
			else {
					load::error('general','No root route set','The root directorie "/" has not define a controller action.');
			}
		
		}
		
		
		// 2) Loops routes
		foreach(self::$route as $pattern=>$location) {
			
			// Skip default route
			if($pattern != '/') {
			
				$pattern_segments = explode('/', $pattern);
				
				// Skip if segment count doesn't match
				// TODO: Add checks for special segment types
				if(count($pattern_segments) == count($segments)) {
					
					$args = array();
					
					// Loop pattern segments
					for($i = 0; $i < count($pattern_segments); $i++) {
						
						// Pattern segment
						if(preg_match('/^:/', $pattern_segments[$i])) {
						
							// Check to see if they don't match pattern
							if(!preg_match(self::$pattern[substr($pattern_segments[$i], 1)], $segments[$i])) {
								
								// Skip to next route entry
								continue 2;
							
							} else {
							
								// Add to arguments array
								$args[] = $segments[$i];
							
							}
						
						// Regular segment
						} else {
						
							// Check to see if they don't match
							if($segments[$i] != $pattern_segments[$i]) {
							
								// Skip to next route entry
								continue 2;
							
							}
						
						}
					
					}
					
					// If it gets to here, then everything matches
					return array('controller'=>$location[0], 'method'=>$location[1], 'args'=>$args);
				
				}
			
			}
		
		}
		
		// If it's here, route not found
		load::error('404');
	}
	
	
	// Controller
	// ---------------------------------------------------------------------------
	public static function controller($path=FALSE)
	{
		return ($path) ? self::$current['controller'] : self::$current['controller_class'];
	}
	
	
	// Method
	// ---------------------------------------------------------------------------
	public static function method()
	{
		return self::$current['function'];
	}
	
	
	// Arguments
	// ---------------------------------------------------------------------------
	public static function arguments()
	{
		return self::$current['arguments'];
	}
}