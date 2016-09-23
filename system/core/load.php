<?php

namespace Salem;

/**
 * Dingo Framework Load Class
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2011
 * @Project Page    http://www.dingoframework.com
 */

class Load
{
	// File
	// ---------------------------------------------------------------------------
	public static function file($folder,$file,$name)
	{
		// If file does not exist display error
		if(!file_exists("$folder/$file.php"))
		{
			dingo_error(E_USER_ERROR,"The requested $name ($folder/$file.php) could not be found.");
			return FALSE;
		}
		else
		{
			require_once("$folder/$file.php");
			return TRUE;
		}
	}
	
	
	// Controller
	// ---------------------------------------------------------------------------
	public static function controller($controller)
	{
		return self::file(APPLICATION.'/'.Config::get('folder_controllers'),$controller,'controller');
	}
	
	
	// Parent Controller
	// ---------------------------------------------------------------------------
	public static function parentController($controller)
	{
		return self::controller($controller);
	}
	
	
	// Model
	// ---------------------------------------------------------------------------
	public static function model($model,$args=array())
	{
		// Model class
		$model_class = explode('/',$model);
		$model_class = end($model_class);
		
		
		if(!class_exists($model_class))
		{
			$path = Config::get('application')."/".Config::get('folder_models')."/$model.php";
			
			// If model does not exist display error
			if(!file_exists($path))
			{
				dingo_error(E_USER_ERROR,"The requested model ($path) could not be found.");
				return FALSE;
			}
			else
			{
				require_once($path);
			}
		}
		
		// Return model class
		return new $model_class();
	}
	
	
	// Parent Model
	// ---------------------------------------------------------------------------
	public static function parentModel($model)
	{
		// Model class
		$model_class = explode('/',$model);
		$model_class = end($model_class).'_model';
		
		
		if(!class_exists($model_class))
		{
			$path = Config::get('application')."/".Config::get('folder_models')."/$model.php";
			
			// If model does not exist display error
			if(!file_exists($path))
			{
				dingo_error(E_USER_ERROR,"The requested model ($path) could not be found.");
				return FALSE;
			}
			else
			{
				require_once($path);
				return TRUE;
			}
		}
	}
	
	
	// Error
	// ---------------------------------------------------------------------------
	public static function error($type = 'general',$title = NULL,$message = NULL)
	{
		ob_clean();
		require_once(Config::get('application').'/'.Config::get('folder_errors')."/$type.php");
		ob_end_flush();
		exit;
	}
	
	
	// Config
	// ---------------------------------------------------------------------------
	public static function config($file)
	{
		return self::file(APPLICATION.'/'.CONFIG,$file,'Configuration');
	}
	
	
	// Language
	// ---------------------------------------------------------------------------
	public static function language($language)
	{
		return self::file(APPLICATION.'/'.Config::get('folder_languages'),$language,'language');
	}
	
	
	// View
	// ---------------------------------------------------------------------------
	public static function view($view,$data = NULL)
	{
		// If view does not exist display error
		if(!file_exists(Config::get('application').'/'.Config::get('folder_views')."/$view.php"))
		{
			dingo_error(E_USER_WARNING,'The requested view ('.Config::get('application').'/'.Config::get('folder_views')."/$view.php) could not be found.");
			return FALSE;
		}
		else
		{
			// If data is array, convert keys to variables
			if(is_array($data))
			{
				extract($data, EXTR_OVERWRITE);
			}
			
			require(Config::get('application').'/'.Config::get('folder_views')."/$view.php");
			return FALSE;
		}
	}
	
	
	// Library
	// ---------------------------------------------------------------------------
	public static function library($library)
	{
		return self::file(SYSTEM.'/library',$library,'library');
	}
	
	
	// Driver
	// ---------------------------------------------------------------------------
	public static function driver($library,$driver)
	{
		return self::file(SYSTEM."/driver/$library",$driver,'driver');
	}
	
	
	
	// Helper
	// ---------------------------------------------------------------------------
	public static function helper($helper)
	{
		return self::file(APPLICATION.'/'.Config::get('folder_helpers'),$helper,'helper');
	}
	
	
	// ORM Class
	// ---------------------------------------------------------------------------
	public static function orm_class($orm)
	{
		return self::file(APPLICATION.'/'.Config::get('folder_orm'),$orm,'ORM');
	}
	
	
	// ORM
	// ---------------------------------------------------------------------------
	public static function orm($orm)
	{
		self::orm_class($orm);
		
		// ORM class
		$orm_class = explode('/',$orm);
		$orm_class = end($orm_class).'_orm';
		
		return new $orm_class();
	}
	
	
	// Parent ORM
	// ---------------------------------------------------------------------------
	public static function parent_orm($orm)
	{
		return self::orm($orm);
	}
}