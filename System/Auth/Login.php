<?php
namespace System\Auth;
use System\Session\Session;
use PDO;
use System\Auth\Crypter;
use Application\Model\Account;

use System\Auth\SimpleGate;
use System\Auth\Gate;

/**
 * Класс авторизации  
 * 
 * @package 
 * @version 0.5
 * @copyright bsu-web
 * @author Derjugin 
 * @license IDK (I Dont Know)
 */
class Login {

	/**
	 * gate  
	 * Объект - способ авторизации
	 *
	 * @var Gate
	 * @access protected
	 */
	protected $gate;


	private static $instance;

	/**
	 * __construct  
	 * 
	 * @param Gate $gate 
	 * @access public
	 * @return void
	 */
	final private function __construct(Gate $gate = NULL){
		if (!$gate){
			$gate = new DefaultGate();	
		}
		$this->gate = $gate;
	}

	/**
	 * instance  
	 * 
	 * @param Gate $gate - метод авторизации 
	 * @static
	 * @access public
	 * @return void
	 */
	public static function instance(Gate $gate = NULL){
		if (!isset(self::$instance)) {
			self::$instance = new self($gate);
		}
		return self::$instance;
	}

	

	/**
	 * Вход пользователя в систему  
	 * 
	 * @param string $user 
	 * @param string $pass 
	 * @access public
	 * @return string OK или DENIED
	 */
	public function SignIn($user, $pass){
		return $this->gate->SignIn($user, $pass);
	}
	
	/**
	 * Выход пользователя из системы  
	 * 
	 * @access public
	 * @return void
	 */
	public function SignOut(){
		$this->gate->SignOut();	

	}
}

?>
