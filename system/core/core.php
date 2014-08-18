<?php

namespace Salem;
use \DataTime;
/**
 * Dingo Cookie Class
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2011
 * @Project Page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/cookie-library
 */

class Cookie
{
	// Set Cookie
	// ---------------------------------------------------------------------------
	public static function set($settings)
	{

		if(!isset($settings['path'])){$settings['path']='/';}
		if(!isset($settings['domain'])){$settings['domain']=FALSE;}
		if(!isset($settings['secure'])){$settings['secure']=FALSE;}
		if(!isset($settings['httponly'])){$settings['httponly']=FALSE;}
		if(!isset($settings['expire']))
		{
			$ex = new \DateTime();
			$time = $ex->format('U');
		}
		else
		{
			$ex = new \DateTime();
			$ex->modify($settings['expire']);
			$time = $ex->format('U');
		}
		
		return setcookie(
			$settings['name'],
			$settings['value'],
			$time,
			$settings['path'],
			$settings['domain'],
			$settings['secure'],
			$settings['httponly']
		);
	}
	
	
	// Delete Cookie
	// ---------------------------------------------------------------------------
	public static function delete($settings)
	{
		if(!isset($settings['path'])){$settings['path']='/';}
		if(!isset($settings['domain'])){$settings['domain']=FALSE;}
		if(!isset($settings['secure'])){$settings['secure']=FALSE;}
		if(!isset($settings['httponly'])){$settings['httponly']=FALSE;}
		
		// If given array of settings
		if(is_array($settings))
		{
			return setcookie(
				$settings['name'],
				'',
				time()-3600,
				$settings['path'],
				$settings['domain'],
				$settings['secure'],
				$settings['httponly']
			);
		}
		// Else, just the cookie name was given
		else
		{
			return setcookie($settings,'',time()-3600);
		}
	}

	public static function get($name)
	{
		if (isset($_COOKIE[$name])){
			return $_COOKIE[$name];
		}else{
			return false;
		}
	}
}