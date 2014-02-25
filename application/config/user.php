<?php

namespace Salem;

// User Database Connection
Config::set('user_connection','default');

// User Database Table
Config::set('user_table','users');

// User Types
Config::set('user_types',array(

	'banned'=>0,
	'guest'=>1,
	'user'=>2,
	'mod'=>3,
	'admin'=>4,
	'owner'=>5

));