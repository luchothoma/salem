<?php 
namespace Salem;
use Salem\db, Salem\load,  Salem\config;
/**
 * Authentication Library For Salem Framework
 *
 * @author          Evan Byrne
 * @copyright       2008 - 2010
 * @project page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/user-library
 */

class auth
{
	public static $table;
	public static $types = array();
	
	public static $_id;
	public static $_email;
	public static $_name;
	public static $_username;
	public static $_password;
	public static $_type;
	public static $_data;
	
	public static $_valid = FALSE;
	
	//Initialize Users Table
	// ---------------------------------------------------------------------------
	public static function init(){
		db::query("CREATE TABLE IF NOT EXISTS `".config::get('user_table')."` ( `id` int(11) NOT NULL AUTO_INCREMENT, `email` varchar(125) NOT NULL, `name` varchar(25) NOT NULL, `username` varchar(25) NOT NULL, `password` varchar(125) NOT NULL, `type` varchar(25) NOT NULL, `data` text NOT NULL, PRIMARY KEY (`id`) )");
	}
	
	// Valid
	// ---------------------------------------------------------------------------
	public static function valid()
	{
		return self::$_valid;
	}
	
	
	// Is Type
	// ---------------------------------------------------------------------------
	public static function isType($t)
	{
		if(self::$_valid OR $t == 'banned')
		{
			// If type of user is equal to or greater than specified return TRUE
			return(self::$types[self::$_type] >= self::$types[$t]);
		}
		else
		{
			// If not a valid user return FALSE
			return FALSE;
		}
	}
	
	
	// Banned
	// ---------------------------------------------------------------------------
	public static function isBanned()
	{
		// Return TRUE is banned, FALSE otherwise
		return(self::$types[self::$_type] === self::$types['banned']);
	}
	
	
	// Check
	// ---------------------------------------------------------------------------
	public static function check($i,$password)
	{
		$valid = FALSE;
		
		// Get information about current user
		if($i AND $password)
		{
			//Hash the password
			$password = self::hash( $password );
			// Find by ID
			if(preg_match('/^([0-9]+)$/',$i))
			{
				$user = self::$table->select('*')
									->where('id','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// Find by Username
			elseif(preg_match('/^([\-_ a-z0-9]+)$/is',$i))
			{
				$user = self::$table->select('*')
									->where('username','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// Find by E-mail
			else
			{
				$user = self::$table->select('*')
									->where('email','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// If valid login credentials
			if(!empty($user[0]))
			{
				// If not banned, mark as valid
				if($user[0]['type'] != 'banned')
				{
					$valid = TRUE;
				}
			}
		}
		
		return $valid;
	}
	
	
	// Get
	// ---------------------------------------------------------------------------
	public static function get($i)
	{
		// Find by ID
		if(preg_match('/^([0-9]+)$/',$i))
		{
			$user = self::$table->select('*')
								->where('id','=',$i)
								->limit(1)
								->execute();
		}
		
		// Find by Username
		elseif(preg_match('/^([\-_ a-z0-9]+)$/is',$i))
		{
			$user = self::$table->select('*')
								->where('username','=',$i)
								->limit(1)
								->execute();
		}
		
		// Find by E-mail
		else
		{
			$user = self::$table->select('*')
								->where('email','=',$i)
								->limit(1)
								->execute();
		}
		
		// If user is found
		if(!empty($user[0]))
		{
			$user[0]['data'] = json_decode($user[0]['data'],true);
			return $user[0];
		}
		
		// Otherwise return FALSE
		else
		{
			return FALSE;
		}
	}
	
	
	// Log In
	// ---------------------------------------------------------------------------
	public static function login($i,$password)
	{
		self::$_valid = FALSE;
		
		// Try to log in
		if($i AND $password)
		{
			//Hash the password
			$password = self::hash($password);
		
			// Find by ID
			if(preg_match('/^([0-9]+)$/',$i))
			{
				$user = self::$table->select('*')
									->where('id','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// Find by Username
			elseif(preg_match('/^([\-_ a-z0-9]+)$/is',$i))
			{
				$user = self::$table->select('*')
									->where('username','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// Find by E-mail
			else
			{
				$user = self::$table->select('*')
									->where('email','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// If valid login credentials
			if(!empty($user[0]))
			{
				$user = $user[0];
				self::$_id = $user['id'];
				self::$_email = $user['email'];
				self::$_name = $user['name'];
				self::$_username = $user['username'];
				self::$_password = $user['password'];
				self::$_type = $user['type'];
				self::$_data = json_decode($user['data'],true);
				
				// If not banned, mark as valid
				if(self::$_type != 'banned')
				{
					self::$_valid = TRUE;
					\session::set('user_email',self::$_email);
					\session::set('user_password',self::$_password);
				}
			}
			
			return self::$_valid;
		}
	}
	
	
	// Log Out
	// ---------------------------------------------------------------------------
	public static function logout()
	{
		\session::delete('user_email');
		\session::delete('user_password');
		
		self::$_id = '';
		self::$_email = '';
		self::$_name = '';
		self::$_username = '';
		self::$_password = '';
		self::$_type = '';
		self::$_data = '';

		self::$_valid = FALSE;
	}
	
	
	// Create
	// ---------------------------------------------------------------------------
	public static function create($user)
	{
		// Make sure data key is set to prevent JSON errors
		if(!isset($user['data']))
		{
			$user['data'] = array();
		}
		
		$user['data'] = json_encode($user['data']);
		$user['password'] = self::hash($user['password']);
		
		return self::$table->insert($user);
	}
	
	
	// Update
	// ---------------------------------------------------------------------------
	public static function update($i=FALSE)
	{
		// Defaults to current user ID
		if(!$i)
		{
			$i = self::$_id;
		}
		
		return new user_update($i,self::$table);
	}
	
	
	// Delete
	// ---------------------------------------------------------------------------
	public static function delete($i)
	{
		// Find by ID
		if(preg_match('/^([0-9]+)$/',$i))
		{
			self::$table->delete('id','=',$i);
		}
		
		// Find by Username
		elseif(preg_match('/^([\-_ a-z0-9]+)$/is',$i))
		{
			self::$table->delete('username','=',$i);
		}
		
		// Find by E-mail
		else
		{
			self::$table->delete('email','=',$i);
		}
	}
	
	
	// Ban
	// ---------------------------------------------------------------------------
	public static function ban($i)
	{
		// Find by ID
		if(preg_match('/^([0-9]+)$/',$i))
		{
			self::$table->update(array('type'=>'banned'))
			            ->where('id','=',$i)
			            ->execute();
		}
		
		// Find by Username
		elseif(preg_match('/^([\-_ a-z0-9]+)$/is',$i))
		{
			self::$table->update(array('type'=>'banned'))
			            ->where('username','=',$i)
			            ->execute();
		}
		
		// Find by E-mail
		else
		{
			self::$table->update(array('type'=>'banned'))
			            ->where('email','=',$i)
			            ->execute();
		}
	}
	
	
	// Exist
	// ---------------------------------------------------------------------------
	public static function exist($i)
	{
		$user=self::get( $i );

		return ( isset($user[0]) );
	}
	
	
	// ID
	// ---------------------------------------------------------------------------
	public static function id()
	{
		return self::$_id;
	}
	
	
	// E-mail
	// ---------------------------------------------------------------------------
	public static function email()
	{
		return self::$_email;
	}
	
	
	// Name
	// ---------------------------------------------------------------------------
	public static function name()
	{
		return self::$_name;
	}


	// Username
	// ---------------------------------------------------------------------------
	public static function username()
	{
		return self::$_username;
	}
	
	
	// Type
	// ---------------------------------------------------------------------------
	public static function type()
	{
		return self::$_type;
	}
	
	
	// Password
	// ---------------------------------------------------------------------------
	public static function password()
	{
		return self::$_password;
	}
	
	
	// Data
	// ---------------------------------------------------------------------------
	public static function data($key)
	{
		return (isset(self::$_data[$key])) ? self::$_data[$key] : NULL;
	}
	
	
	// Hash
	// ---------------------------------------------------------------------------
	public static function hash($i)
	{
		return sha1($i);
	}
}


/**
 * User Authentication Library User Update Class For Dingo Framework
 *
 * @author          Evan Byrne
 * @copyright       2008 - 2010
 * @project page    http://www.dingoframework.com
 */
class user_update
{
	private $table;
	private $exists = TRUE;
	
	public $id;
	public $email;
	public $name;
	public $username;
	public $password;
	public $type;
	public $data;
	
	
	// Construct
	// ---------------------------------------------------------------------------
	public function __construct($i,$table)
	{
		$this->table = $table;
		
		// Find by ID
		if(preg_match('/^([0-9]+)$/',$i))
		{
			$user = $this->table->select('*')
			                    ->where('id','=',$i)
			                    ->limit(1)
			                    ->execute();
		}
		
		// Find by Username
		elseif(preg_match('/^([\-_ a-z0-9]+)$/i',$i))
		{
			$user = $this->table->select('*')
			                    ->where('username','=',$i)
			                    ->limit(1)
			                    ->execute();
		}
		
		// Find by E-mail
		else
		{
			$user = $this->table->select('*')
			                    ->where('email','=',$i)
			                    ->limit(1)
			                    ->execute();
		}
		
		if(isset($user[0]))
		{
			$this->id = $user[0]['id'];
			$this->email = $user[0]['email'];
			$this->name = $user[0]['name'];
			$this->username = $user[0]['username'];
			$this->password = $user[0]['password'];
			$this->type = $user[0]['type'];
			$this->data = json_decode($user[0]['data'],true);
		}
		else
		{
			$this->exists = FALSE;
		}
	}
	
	
	// ID
	// ---------------------------------------------------------------------------
	public function id($id)
	{
		$this->id = $id;
		return $this;
	}
	
	
	// E-mail
	// ---------------------------------------------------------------------------
	public function email($email)
	{
		$this->email = $email;
		return $this;
	}
	
	
	// Name
	// ---------------------------------------------------------------------------
	public function name($name)
	{
		$this->name = $name;
		return $this;
	}


	// Username
	// ---------------------------------------------------------------------------
	public function username($username)
	{
		$this->username = $username;
		return $this;
	}
	
	
	// Password
	// ---------------------------------------------------------------------------
	public function password($password)
	{
		$this->password = $this->hash($password);
		return $this;
	}
	
	
	// Type
	// ---------------------------------------------------------------------------
	public function type($type)
	{
		$this->type = $type;
		return $this;
	}
	
	
	// Data
	// ---------------------------------------------------------------------------
	public function data($key,$value)
	{
		$this->data[$key] = $value;
		return $this;
	}
	
	
	// Save
	// ---------------------------------------------------------------------------
	public function save()
	{
		$this->table->update(array(
						'id'=>$this->id,
						'email'=>$this->email,
						'name'=>$this->name,
						'username'=>$this->username,
						'password'=>$this->password,
						'type'=>$this->type,
						'data'=>json_encode($this->data)
					))
		            ->where('id','=',$this->id)
		            ->execute();
		
		return $this;
	}
	
	
	// Hash
	// ---------------------------------------------------------------------------
	public function hash($i)
	{
		return sha1($i);
	}
}

// Load config file
load::config('user');

//Initialize auth
//auth::init();

auth::$types = config::get('user_types');

// Set database table
auth::$table = db::db(config::get('user_table'),NULL,config::get('user_connection'));

// Get session data
auth::$_email = \session::get('user_email');
auth::$_password = \session::get('user_password');

// Get information about current user
if(auth::$_email AND auth::$_password)
{
	$user = auth::$table->select('*')
						->where('email','=',auth::$_email)
						->clause('AND')
						->where('password','=',auth::$_password)
						->limit(1)
						->execute();
	
	// If valid login credentials
	if(!empty($user[0]))
	{
		$user = $user[0];
		auth::$_id = $user['id'];
		auth::$_email = $user['email'];
		auth::$_name = $user['name'];
		auth::$_username = $user['username'];
		auth::$_password = $user['password'];
		auth::$_type = $user['type'];
		auth::$_data = json_decode($user['data'],true);
		
		// If not banned, mark as valid
		if(auth::$_type != 'banned')
		{
			auth::$_valid = TRUE;
		}
	}
}