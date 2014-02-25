<?php

namespace Salem;

Route::add(array(

	//'/'=>'main.index',
	'/'=>'main.example',
	'one/two'=>'main.foo',
	
	'int/:int'=>'main.bar',
	'numeric/:numeric'=>'main.bar',
	'alpha/:alpha'=>'main.bar',
	'alpha-int/:alpha-int'=>'main.bar',
	'alpha-numeric/:alpha-numeric'=>'main.bar',
	'words/:words'=>'main.bar',
	'any/:any'=>'main.bar',
	'extension/:extension'=>'main.bar'
	
));
