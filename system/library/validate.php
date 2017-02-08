<?php 
namespace Salem;
/**
 * Dingo Framework Validation Helper
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/validation-helper
 */
class validate
{
	private static $ok;
	// Username
	// ---------------------------------------------------------------------------
	public static function username($username)
	{
		return preg_match('/^([\-_ a-z0-9]+)$/is',$username)==1;
	}
	
	
	// Name
	// ---------------------------------------------------------------------------
	public static function name($name)
	{
		return preg_match('/^([ a-z]+)$/is',$name)==1;
	}
	
	
	// Number
	// ---------------------------------------------------------------------------
	public static function number($number)
	{
		return preg_match('/^([\.0-9]+)$/is',$number)==1;
	}
	
	
	// Int
	// ---------------------------------------------------------------------------
	public static function int($int)
	{
		return preg_match('/^([0-9]+)$/is',$int)==1;
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
		return filter_var( $email, FILTER_VALIDATE_EMAIL) != false;
	}
	
	
	// Phone Number
	// ---------------------------------------------------------------------------
	public static function phone($phone,$strict=false)
	{
		if(!$strict)
		{
			$phone = preg_replace('/([ \(\)\-\+]+)/','',$phone);
		}
		
		return preg_match('/^([0-9]+)$/',$phone)==1;
	}
	// Url Address
	// ---------------------------------------------------------------------------
	public static function url($url)
	{
		return filter_var( $url, FILTER_VALIDATE_URL) != false;
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
		return preg_match($exp, $val)==1;
	}	
	// Exe
	// ---------------------------------------------------------------------------
	private static function exe($rule,$data, $msg){
		$info = explode(':', $rule,2);
		$devolver = '';
		switch ($info[0]) {
			case 'username':
				if (! (self::username($data)) ) $devolver = ( !is_null($msg) && isset($msg[$info[0]]) )? $msg[$info[0]]:'Not a valid username';
				break;
			case 'name':
				if (! (self::name($data)) ) $devolver = ( !is_null($msg) && isset($msg[$info[0]]) )? $msg[$info[0]]:'Not a valid name';
				break;
			case 'number':
				if (! (self::number($data)) ) $devolver = ( !is_null($msg) && isset($msg[$info[0]]) )? $msg[$info[0]]:'Not a number';
				break;
			case 'int':
				if (! (self::int($data)) ) $devolver = ( !is_null($msg) && isset($msg[$info[0]]) )? $msg[$info[0]]:'Not an integer';
				break;
			case 'range':
				$val = explode ('to', $info[1]);
				if (! (self::range( intval($val[0] ), intval($val[1]), $data)) ) $devolver = ( !is_null($msg) && isset($msg[$info[0]]) )? $msg[$info[0]]:'Value not in range('.$val[0].'-'.$val[1].')';
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
				if (! (self::length($low, $high, $data)) ) $devolver = ( !is_null($msg) && isset($msg[$info[0]]) )? $msg[$info[0]]:'Not valid length'; 
				break;
			case 'email':
				if (! (self::email($data)) ) $devolver = ( !is_null($msg) && isset($msg[$info[0]]) )? $msg[$info[0]]:'Not an email';
				break;
			case 'phone':
				if (! (self::phone($data)) ) $devolver = ( !is_null($msg) && isset($msg[$info[0]]) )? $msg[$info[0]]:'Not a phone number';
				break;
			case 'url':
				if (! (self::url($data)) ) $devolver = ( !is_null($msg) && isset($msg[$info[0]]) )? $msg[$info[0]]:'Not a url';
				break;
			case 'required':
				if (! (self::required($data)) ) $devolver = ( !is_null($msg) && isset($msg[$info[0]]) )? $msg[$info[0]]:'Not completed';
				break;
			case 'regex':
				if (! (self::regex( $info[1], $data)) ) $devolver = ( !is_null($msg) && isset($msg[$info[0]]) )? $msg[$info[0]]:'Not verify the regex';
				break;
			default:
				$devolver = 'Not defined rule';
				break;
		}
		return $devolver;
	}
	// Test
	// ---------------------------------------------------------------------------
	public static function test($values,$rules,$messages = null){
		$returnArr = array();
		self::$ok = true;
		foreach ($values as $key => $value) {
			if(!isset($rules[$key])){
				$returnArr[$key]='No rule for {$key}';
			}else{
				//analizar array de reglas a testear y aplicar
				//$returnArr[$key]= ''; se comenta para que no devuelva las reglas que psaron el test vacias y solo devuelva las que fallaron
				for($x=0;$x<count($rules[$key]); $x++){
					$msg = (is_array($messages) && isset($messages[$key]))? $messages[$key] : null ;
					$result= self::exe( $rules[$key][$x], $values[$key] , $msg );
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
	$values=array(
 		'nombre'=> 'holer',
 		'edad'=> 'holanda9e'
 	);
 	$rules=array(
 		'nombre'=>array('required','length:3'),
 		'edad'=>array('required','regex:/^t.*9[a-z]*$/i')//'int','range:0to110')
 	);
 	$messages=array(
 		'nombre'=>array('required'=> 'No completo el nombre','length'=> 'Largo mayor al permitido'),
 		'edad'=>array('required'=> 'No completo la edad','regex'=>'Solo use caracteres permitidos')//'int','range:0to110')
 	);
	*/
}