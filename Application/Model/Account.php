<?php
namespace Application\Model;


use System\Orm\DomainObject;

/**
 * Авторизационный класс  
 * 
 * @uses DomainObject
 * @package Auth
 * @version 0.1
 * @copyright bsu-web
 * @author Derjugin 
 * @license IDK (I Dont Know)
 */
class Account extends DomainObject{
	/**
	 * логин пользователя 
	 * 
	 * @var string
	 * @access private
	 */
	private $login;

	/**
	 * пароль  
	 * 
	 * @var string
	 * @access private
	 */
	private $pass;

	/**
	 * соль  
	 * 
	 * @var string
	 * @access private
	 */
	private $salt;

	/**
	 * глобальная группа. Например, админ.  
	 * 
	 * @var string
	 * @access private
	 */

	private $groups;

	public function getGroupList(){
		return $this->group; 
	}

	public function setGroup($group){
		$this->groups[] = $group;
	}

	/**
	 * Получить логина  
	 * 
	 * @access public
	 * @return string
	 */
	public function getLogin(){
		return $this->login;
	}	
	
	/**
	 * Установить логин  
	 * 
	 * @param string $login 
	 * @access public
	 * @return void
	 */
	public function setLogin($login){
		$this->login = $login;
		$this->markDirty();
	}

	/**
	 * Получить пароль  
	 * 
	 * @access public
	 * @return string
	 */
	public function getPass(){
		return $this->pass;
	}

	/**
	 * Установить паролль  
	 * 
	 * @param string $pass 
	 * @access public
	 * @return void
	 */
	public function setPass($pass){
		$this->pass = $pass;
		$this->markDirty();
	}
	
	/**
	 * Получить соль  
	 * 
	 * @access public
	 * @return string
	 */
	public function getSalt(){
		return $this->salt;
	}

	/**
	 * Установить соль  
	 * 
	 * @param string $salt 
	 * @access public
	 * @return void
	 */
	public function setSalt($salt){
		$this->salt = $salt;
		$this->markDirty();
	}

	/**
	 * Получить глобальную роль  
	 * 
	 * @access public
	 * @return string
	 */
	public function getStatus(){
		return $this->status;	
	}

	/**
	 * Установить роль  
	 * 
	 * @param string $status 
	 * @access public
	 * @return void
	 */
	public function setStatus($status){
		$this->status = $status;
		$this->markDirty();
	}

	public function targetClass(){
		return 'Account';
	}
}	


?>
