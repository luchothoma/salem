<?php

namespace Salem;

/**
 * Dingo Framework Basic Configuration File
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 */


// Application's Base URL
define('BASE_URL','http://localhost/dingo/');

// Does Application Use Mod_Rewrite URLs?
//define('MOD_REWRITE',FALSE);
define('MOD_REWRITE',TRUE);

// Turn Debugging On?
define('DEBUG',TRUE);

// Turn Error Logging On?
define('ERROR_LOGGING',FALSE);

// Error Log File Location
define('ERROR_LOG_FILE','log.txt');


/**
 * Your Application's Default Timezone
 * Syntax for your local timezone can be found at
 * http://www.php.net/timezones
 */
date_default_timezone_set('America/New_York');


/* Auto Load Libraries */
Config::set('autoload_library',array('db','url','session'));

/* Auto Load Helpers */
Config::set('autoload_helper',array());


/* Sessions */
Config::set('session',array(
	'connection'=>'default',
	'table'=>'sessions',
	'cookie'=>array('path'=>'/','expire'=>'+1 months')
));

/* Notes */
Config::set('notes',array('path'=>'/','expire'=>'+5 minutes'));


/* Application Folder Locations */
Config::set('folder_views','view');             // Views
Config::set('folder_controllers','controller'); // Controllers
Config::set('folder_models','model');           // Models
Config::set('folder_helpers','helper');         // Helpers
Config::set('folder_languages','lang');     // Languages
Config::set('folder_errors','error');           // Errors
Config::set('folder_orm','orm');                // ORM