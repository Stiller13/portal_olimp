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
	static private $default_salt = "axqfHJAgtH!#&%";

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
		$result_pass = sha1(sha1($salt).sha1($pass).sha1(self::$default_salt));
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
