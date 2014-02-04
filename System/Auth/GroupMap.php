<?php

namespace System\Auth;
use System\Auth\Group;
use PDO;
use System\Core\Application;
use System\Auth\Role;
use System\Auth\Rule;

class GroupMap {
	/**
	 * Массив групп (Group)  
	 * 
	 * @var array
	 * @access private
	 */
	private $rules = array();

	private $roles = array();

	/**
	 * GroupMap - sigletone 
	 */	
	private static $instance;

	/**
 	* Конструктор 
 	*/
	private function __construct(){
		$app = Application::instance();
		
		$config = $app->getData("rules");
		$rule = new Rule();
		$this->rules = $this->parse($config, "rule");


		$config = $app->getData("roles");
		$role = new Role();
		$this->roles = $this->parse($config, "role");
	
	}
	
	/**
	 * instance  
	 * 
	 * @static
	 * @access public
	 * @return GroupMap
	 */
	public static function instance(){
		if(!self::$instance){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * Добавление группы 
	 * 
	 * @param Group $group 
	 * @access public
	 * @return void
	 */
	public function addRule(Group $group){
		$this->rules[$group->getName()] = $group;
	}

	public function addRole(Group $group){
		$this->roles[$group->getName()] = $group;
	}
		
	
	/**
	 * Получение группы (Group)  
	 * 
	 * @param string $group_name 
	 * @access public
	 * @return Group
	 */
	public function getRule($rule_name){
		if (isset($this->rules[$rule_name])) {
			return $this->rules[$rule_name];
		}
		return null;
	}

	public function getRole($role_name){
		if (isset($this->roles[$role_name])){
			return $this->roles[$role_name];
		}
		return null;
	}

	public function parse($config, $type){ 
		$result = array();
		foreach ($config->group as $group){
			$name = (string)$group["name"];
			$parent = (string)$group["parent"];
			
			if (!$parent) {
				$parent = null;
			}

			if($type == "rule"){
				$obj = new Rule();
			}
			else{
				$obj = new Role();
			}


			$obj->setName($name);
			$obj->setParentName($parent);
			
			$allow = $group->allow->command;
			$deny = $group->deny->command;

			
			if ($allow) {
				foreach ($group->allow->command as $cmd){
					$status = $cmd->status;
					$statuses = array();
					if ($status) {
						foreach ($status as $st) {
							$statuses[] = (string)$st["name"];
						}
					}
					$obj->Allow((string)$cmd["class"], $statuses);
				}
			}
		
							
			
			if ($deny) {
				foreach ($group->deny->command as $cmd){
					$status = $cmd->status;
					$statuses = array();
					if ($status) {
						foreach ($status as $st) {
							$statuses[] = (string)$st["name"];
						}
					}
					$obj->Deny((string)$cmd["class"], $statuses);
				}
			}
			$result[$obj->getName()] = $obj;
			
		}
		return $result;		
	}
}

?>
