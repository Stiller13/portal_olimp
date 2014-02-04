<?php
namespace System\Auth;

/**
 * Crypter - класс шифровщик (пока только пароли) 
 * 
 * @package 
 * @version 0.1
 * @copyright bsu-web
 * @author Derjugin 
 * @license IDK (I Dont Know)
 */
class Crypter {
	
	/**
	 * соль по умочанию 
	 * 
	 * @var string
	 * @access private
	 */
	private $default_salt = "axqfHJAgtH!#&%";

	public function __construct(){
	}

	/**
	 *  
	 * 
	 * @param string $pass - строка, которую нужно зашифровать 
	 * @param string $salt - соль на строку.
	 * @access public
	 * @return string - шифрованный пароль
	 */
	static public function genPass($pass, $salt){
		$result_pass = md5(md5($salt).md5($pass).md5($default_pass));
		return $result_pass;
	}

	/**
	 * Генерирует случайную строку 
	 * 
	 * @param int $length 
	 * @static
	 * @access private
	 * @return void
	 */
	static private function genString($length){
		$code = '';
	        $symbols = '0123456789abcdefghijklmnopqrstuvwxyz_-~!+*%$#&';
        	for( $i = 0; $i < $length; $i++ ){
	            $num = rand(1, strlen($symbols));
        	    $str .= substr( $symbols, $num, 1 );   
		}
 				
        	return $str;
	}

	static public function genSalt(){
		$salt = self::genString(14);
		return $salt;
	}
}

?>
