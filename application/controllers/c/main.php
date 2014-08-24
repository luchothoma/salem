<?php

namespace Controller;
use Salem\Route, Salem\Cookie, Salem\View;

class Main {

	public function index() {
	
		View::render('hello');
	
	}
	
	public function foo() {
	
		echo 'Foooo!';
	
	}
	
	public function bar($m = false) {
	echo $m.'<br>';
		print_r(func_get_args());
	
	}

	public function example() {
	
		View::render('prueba',['algo'=>date('U')]);
	//Routing views to subFolders like "/views/v/prueba.php is like 'v/prueba'
	}
}