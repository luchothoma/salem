<?php 
namespace Salem;


/**
 * Dingo Framework URL Library
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/url-helper
 */

class url
{
	// Base URL
	// ---------------------------------------------------------------------------
	public static function base($ShowIndex = FALSE)
	{
		if($ShowIndex AND !MOD_REWRITE)
		{
			// Include "index.php"
			return(BASE_URL.'index.php/');
		}
		else
		{
			// Don't include "index.php"
			return(BASE_URL);
		}
	}
	
	
	// Page URL
	// ---------------------------------------------------------------------------
	public static function page($path = FALSE)
	{
		if(MOD_REWRITE)
		{
			return(url::base().$path);
		}
		else
		{
			return(url::base(TRUE).$path);
		}
	}
	
	
	// Redirect
	// ---------------------------------------------------------------------------
	public static function redirect($url = '')
	{
		header('Location: '.$url);
		exit;
	}


	// Is Ajax Petition
	// ---------------------------------------------------------------------------
	public static function isAjax()
	{
		return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true : false;
	}


	// Is Post Petition
	// ---------------------------------------------------------------------------
	public static function isPost()
	{
		return ( $_SERVER['REQUEST_METHOD'] == 'POST' ) ;
	}


	// Is Get Petition
	// ---------------------------------------------------------------------------
	public static function isGet()
	{
		return ( $_SERVER['REQUEST_METHOD'] == 'GET' ) ;
	}

	// Return the actually request url
	// ---------------------------------------------------------------------------
	public static function actually()
	{
		//To see why I do this, check system/core/bootstrap.php
		return constant('CURRENT_PAGE');
	}
}