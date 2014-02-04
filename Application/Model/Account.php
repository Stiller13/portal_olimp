<?php
namespace Application\Model;


use System\Orm\DomainObject;

/**
 * ��������������� �����  
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
	 * ����� ������������ 
	 * 
	 * @var string
	 * @access private
	 */
	private $login;

	/**
	 * ������  
	 * 
	 * @var string
	 * @access private
	 */
	private $pass;

	/**
	 * ����  
	 * 
	 * @var string
	 * @access private
	 */
	private $salt;

	/**
	 * ���������� ������. ��������, �����.  
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
	 * �������� ������  
	 * 
	 * @access public
	 * @return string
	 */
	public function getLogin(){
		return $this->login;
	}	
	
	/**
	 * ���������� �����  
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
	 * �������� ������  
	 * 
	 * @access public
	 * @return string
	 */
	public function getPass(){
		return $this->pass;
	}

	/**
	 * ���������� �������  
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
	 * �������� ����  
	 * 
	 * @access public
	 * @return string
	 */
	public function getSalt(){
		return $this->salt;
	}

	/**
	 * ���������� ����  
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
	 * �������� ���������� ����  
	 * 
	 * @access public
	 * @return string
	 */
	public function getStatus(){
		return $this->status;	
	}

	/**
	 * ���������� ����  
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
