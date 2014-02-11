<?php
namespace Application\Model;


/**
 * RuleObj 
 * Права на объект
 * @uses DomainObject
 * @package Auth
 * @version 0.1
 * @copyright bsu-web
 * @author Derjugin 
 * @license IDK (I Dont Know)
 */
class RuleObj extends \System\Orm\DomainObject{
	/**
	 * Id пользователя 
	 * 
	 * @var int
	 * @access private
	 */
	private $user_id;

	/**
	 * Id объекта  
	 * 
	 * @var int
	 * @access private
	 */
	private $obj_id;

	/**
	 * Тип объекта  
	 * 
	 * @var string
	 * @access private
	 */
	private $obj_type;

	/**
	 * Роль пользователя к этому объекту  
	 * 
	 * @var string
	 * @access private
	 */
	private $rule;

	/**
	 * Получение id пользователя  
	 * 
	 * @access public
	 * @return int
	 */
	public function getUser_id(){
		return $this->user_id;
	}	
	
	/**
	 * Установить id пользователя  
	 * 
	 * @param int $user_id 
	 * @access public
	 * @return void
	 */
	public function setUser_id($user_id){
		$this->user_id = $user_id;
		$this->markDirty();
	}

	/**
	 * Получение id объекта  
	 * 
	 * @access public
	 * @return int
	 */
	public function getObj_id(){
		return $this->obj_id;
	}

	/**
	 * Установить id объекта  
	 * 
	 * @param mixed $obj_id 
	 * @access public
	 * @return void
	 */
	public function setObj_id($obj_id){
		$this->obj_id = $obj_id;
		$this->markDirty();
	}

	/**
	 * Получение типа объекта  
	 * 
	 * @access public
	 * @return string
	 */
	public function getObj_type(){
		return $this->obj_type;
	}

	/**
	 * Установить тип объекта  
	 * 
	 * @param string $obj_type 
	 * @access public
	 * @return void
	 */
	public function setObj_type($obj_type){
		$this->obj_type = $obj_type;
		$this->markDirty();
	}

	/**
	 * Получение роли пользователя к объекту  
	 * 
	 * @access public
	 * @return string
	 */
	public function getRule(){
		return $this->rule;
	}

	/**
	 * Установить роль пользователя к объекту  
	 * 
	 * @param string $rule
	 * @access public
	 * @return void
	 */
	public function setRule($rule){
		$this->rule = $rule;
		$this->markDirty();
	}

	public function targetClass(){
		return 'RuleObj';
	}
}	


?>
