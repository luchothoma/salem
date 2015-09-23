<?php

namespace Salem;
use Salem\Load;

/**
 * Dingo Framework View Class
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2011
 * @Project Page    http://www.dingoframework.com
 */

class View {
	
	private static $extensions = array();
	private static $sections = array();
	private static $current_section = false;
	private static $current_new_section = false;
	
	
	// Render
	// ---------------------------------------------------------------------------
	public static function render($view, $data=array()) {
		
		Load::view($view, $data);
		
		// Load extensions
		foreach(self::$extensions as $e) {
		
			//print_r($e);
			Load::view($e['view'], $e['data']);
		
		}
		
		//print_r(self::$sections);
	
	}
	
	
	// Extend
	// ---------------------------------------------------------------------------
	public static function extend($view, $data= array()) {

		self::$extensions[] = array('view'=>$view, 'data'=>$data);
	
	}
	
	
	// Section
	// ---------------------------------------------------------------------------
	public static function section($name) {
	
		ob_clean();
		self::$current_section = $name;
		ob_end_flush();
		ob_start();
	
	}
	
	
	// End Section
	// ---------------------------------------------------------------------------
	public static function end_section() {
	
		$data = ob_get_clean();
		self::$sections[self::$current_section] = $data;
		self::$current_section = false;
		ob_start();
	
	}
	
	
	// New Section
	// ---------------------------------------------------------------------------
	public static function new_section($name, $default=false) {
		//default
		//TRUE = overide the content
		//FALSE = append new-content to content	
		if(!$default) {
		
			echo self::$sections[$name];
			
		} else {
			
			self::$current_new_section = $name;
			ob_end_flush();
			ob_start();
		
		}
	
	}
	
	
	// End New Section
	// ---------------------------------------------------------------------------
	public static function end_new_section() {
	
		if(isset(self::$sections[self::$current_new_section])) {
		
			ob_clean();
			echo self::$sections[self::$current_new_section];
		
		}
		
		self::$current_new_section = false;
	
	}
	
}