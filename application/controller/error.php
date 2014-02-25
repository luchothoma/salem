<?php

namespace Controller;


class Error {

	public function _404() {
	
		header('HTTP/1.1 404 Not Found');
		echo 'Error: Page not found.';
	
	}

}