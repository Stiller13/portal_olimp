<?php

namespace System\Auth;

/**
 * Group - группа прав  
 * 
 * @package 
 * @version 0.5
 * @copyright bsu-web
 * @author Derjugin 
 * @license IDK (I Dont Know)
 */

abstract class Group {
	/**
	 * Список разрешенных команд 
	 * 
	 * @var array 
	 * @access private
	 */
	protected $allow = array();
	
	/**
	 * Список запрещенных команд 
	 * 
	 * @var array
	 * @access private
	 */
	protected $deny = array();

	/**
	 * Имя предка
	 * 
	 * @var string
	 * @access private
	 */
	protected $parent;
	
	/**
	 * Свое имя 
	 * 
	 * @var string
	 * @access private
	 */
	protected $name;
	
	/**
	 * Конструктор 
	 * 
	 * @param string $parent 
	 * @access public
	 * @return void
	 */
	public function __construct(){}
	
	/**
	 * Узнать предка  
	 * 
	 * @access public
	 * @return void
	 */
	public function getParentName(){
		return $this->parent;
	}

	/**
	 * Задать предка  
	 * 
	 * @access public
	 * @return void
	 */
	public function setParentName($parent){ 
		$this->parent = $parent;
	}
	
	/**
	 * Узнать имя  
	 * 
	 * @access public
	 * @return void
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Здать имя  
	 * 
	 * @param mixed $name 
	 * @access public
	 * @return void
	 */
	public function setName($name){
		$this->name = $name;
	}
	
	/**
	 * Разрешить группе выполнение команды  
	 * 
	 * @param string $cmd 
	 * @access public
	 * @return void
	 */
	public function Allow($cmd, $statuses = null){
		if (!isset($this->allow[$cmd])) {
			$this->allow[$cmd] = $statuses;
		}
		
		if ($this->isDenied($cmd, $statuses)) {
			unset($this->deny[$cmd]);
		}
	}
	
	/**
	 * Запретить группе выполнение команды  
	 * 
	 * @param string $cmd 
	 * @access public
	 * @return void
	 */
	public function Deny($cmd, $statuses = null){
		if (!isset($this->deny[$cmd])) {
			$this->deny[$cmd] = $statuses;
		}
		
		if ($this->isAllowed($cmd, $statuses)) {
			unset($this->allow[$cmd]);
		}
	}
	
	/**
	 * Разрешена ли команда  
	 * Вернет true, если разрешена, false - если нет
	 *
	 * @param string $cmd 
	 * @access public
	 * @return boolean
	 */
	public function isAllowed($cmd, $status = null){
		if (isset($this->allow[$cmd])) {
			if (in_array($status, $this->allow[$cmd]) || !$status || !$this->allow[$cmd]) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Запрещена ли команда  
	 * Вернет true, если запрещена, false - если нет
	 *
	 * @param string $cmd 
	 * @access public
	 * @return boolean
	 */
	public function isDenied($cmd, $status = null){
		if (isset($this->deny[$cmd])) {
			if (in_array($status, $this->deny[$cmd]) || !$status || !$this->deny[$cmd]) {
				return true;
			}
		}
		return false;
	}

	abstract function getParent();
	
}

?>
