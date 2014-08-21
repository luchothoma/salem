<?php

namespace Salem;

/**
 * Dingo Framework DB Configuration File
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 */

Config::set('db',array(
	
	/* Default Connection */
	'default'=>array(
	
		'driver'=>'mysql',       // Driver
		'host'=>'localhost',     // Host
		'username'=>'root',      // Username
		'password'=>'',          // Password
		'database'=>'mybase'       // Database
	),

	'other'=>array(
		'driver'=>'mysql',       // Driver
		'host'=>'localhost',     // Host
		'username'=>'root',      // Username
		'password'=>'',          // Password
		'database'=>'ejemplo'       // Database
	)
));