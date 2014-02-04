<?php
namespace System\Auth;

/**
 * Класс, определяющий метод авторизации 
 * 
 * @abstract
 * @package 
 * @version 0.1
 * @copyright bsu-web
 * @author Derjugin 
 * @license IDK (I Dont Know)
 */
abstract class Gate {
	
	/**
	 * Вход пользователя 
	 * 
	 * @param mixed $user 
	 * @param mixed $pass 
	 * @abstract
	 * @access public
	 * @return void
	 */
	abstract public function SignIn($user, $pass);

	/**
	 * Выход пользователя 
	 * 
	 * @abstract
	 * @access public
	 * @return void
	 */
	abstract public function SignOut();
	
}

?>
