<?php 
//namespace Salem;
/**
 * Dingo Framework Validation Helper
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/validation-helper
 */

class valid
{
	private static $ok;

	// Username
	// ---------------------------------------------------------------------------
	public static function username($username)
	{
		return preg_match('/^([\-_ a-z0-9]+)$/is',$username);
	}
	
	
	// Name
	// ---------------------------------------------------------------------------
	public static function name($name)
	{
		return preg_match('/^([ a-z]+)$/is',$name);
	}
	
	
	// Number
	// ---------------------------------------------------------------------------
	public static function number($number)
	{
		return preg_match('/^([\.0-9]+)$/is',$number);
	}
	
	
	// Int
	// ---------------------------------------------------------------------------
	public static function int($int)
	{
		return preg_match('/^([0-9]+)$/is',$int);
	}
	
	
	// Range
	// ---------------------------------------------------------------------------
	public static function range($low,$high,$number)
	{
		return ($low <= $number AND $high >= $number);
	}
	
	
	// Length
	// ---------------------------------------------------------------------------
	public static function length($low,$high,$string)
	{
		return self::range($low,$high,strlen($string));
	}
	
	
	// Email Address
	// ---------------------------------------------------------------------------
	public static function email($email)
	{
		return filter_var( $url, FILTER_VALIDATE_EMAIL);
	}
	
	
	// Phone Number
	// ---------------------------------------------------------------------------
	public static function phone($phone,$strict=false)
	{
		if(!$strict)
		{
			$phone = preg_replace('/([ \(\)\-]+)/','',$phone);
		}
		
		return preg_match('/^([0-9]{10})$/',$phone);
	}

	// Url Address
	// ---------------------------------------------------------------------------
	public static function url($url)
	{
		return filter_var( $url, FILTER_VALIDATE_URL);
	}
	
	// Required
	// ---------------------------------------------------------------------------
	public static function required($required)
	{
		return ($required != "");
	}

	// Regex
	// ---------------------------------------------------------------------------
	public static function regex($exp,$val)
	{
		return preg_match($exp, $val);
	}	

	// Exe
	// ---------------------------------------------------------------------------
	private static function exe($rule,$data){
		$info = explode(':', $rule);
		$devolver = '';
		switch ($info[0]) {
			case 'username':
				if (! (self::username($data)) ) $devolver = 'Not a valid username';
				break;
			case 'name':
				if (! (self::name($data)) ) $devolver = 'Not a valid name';
				break;
			case 'number':
				if (! (self::number($data)) ) $devolver = 'Not a number';
				break;
			case 'int':
				if (! (self::int($data)) ) $devolver = 'Not a integer';
				break;
			case 'range':
				$val = explode ('to', $info[1]);
				if (! (self::range( intval($val[0] ), intval($val[1]), $data)) ) $devolver = 'Value not in range'; 
				break;
			case 'length':
				$val = explode ('to', $info[1]);
				$low = '';
				$high = '';
				if (sizeOf($val)==1){
					$low = '0';
					$high = $val[0];		
				}else{
					$low = $val[0];
					$high = $val[1];
				}
				if (! (self::length($low, $high, $data)) ) $devolver = 'Not valid length'; 
				break;
			case 'email':
				if (! (self::email($data)) ) $devolver = 'Not an email';
				break;
			case 'phone':
				if (! (self::phone($data)) ) $devolver = 'Not a phone number';
				break;
			case 'url':
				if (! (self::url($data)) ) $devolver = 'Not a url';
				break;
			case 'required':
				if (! (self::required($data)) ) $devolver = 'Not complete';
				break;
			case 'regex':
				if (! (self::regex($data)) ) $devolver = 'Not verify the regex';
				break;
			default:
				$devolver = 'Not defined rule';
				break;
		}
		return $devolver;
	}

	// Test
	// ---------------------------------------------------------------------------
	public static function test($values,$rules){
		$returnArr = array();
		self::$ok = true;
		foreach ($values as $key => $value) {
			if(!isset($rules[$key])){
				$returnArr[$key]='No rule for {$key}';
			}else{
				//analizar array de reglas a testear y aplicar
				$returnArr[$key]= '';
				for($x=0;$x<count($rules[$key]); $x++){
					$result= self::exe( $rules[$key][$x], $values[$key]);
					if ($result <> ''){
						$returnArr[$key] = $result;
						self::$ok = false;
						break;
					}
				}
			}
		}
		return $returnArr;
	}

	public static function success(){
		return self::$ok;
	}

	/*
	$values{
		nombre: 'hola',
		edad: '13'
	}
	$rules{
		nombre:['required','length:14'],
		edad:['required','int','range:0to110']
	}
	*/
}