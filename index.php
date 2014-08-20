<?php

error_reporting(E_STRICT|E_ALL);

// Application configuration
//----------------------------------------------------------------------------------------------

// Dingo Location
define('SYSTEM','system');

// Application Location
define('APPLICATION','application');

// Config Directory Location (in relation to application location)
define('CONFIG','configuration');

// Allowed Characters in URL
define('ALLOWED_CHARS','/^[ \!\,\~\&\.\:\+\@\-_a-zA-Z0-9]+$/');


// End of configuration
//----------------------------------------------------------------------------------------------

//STARTING FRAMEWORK
define('DINGO',1);
require_once(SYSTEM.'/core/bootstrap.php');
\Salem\Bootstrap::run();