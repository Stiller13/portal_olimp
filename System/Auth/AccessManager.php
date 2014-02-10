<?php
namespace System\Auth;

use System\Core\Application;
use System\Core\Command;
use System\Auth\GroupMap;
use System\Auth\Group;
use System\Session\Session;
use System\Orm\PersistenceFactory;
use System\Orm\DomainObjectAssembler;
use System\Orm\IdentityObject;
use Application\Model\RuleObj;
use Application\Model\StatusObj;
use System\Auth\Role;
use System\Auth\Rule;
use System\Orm\UserRole;

/**
 * AccessManager - класс управления доступом к командам и объектам 
 *  
 * @version 1.5
 * @copyright bsu-web
 * @author Derjugin 
 * @license IDK (I Dont Know)
 */
class AccessManager {
	/**
	 * AccessManager - sigletone 
	 */
	private static $instance;	
	
	public static function instance(){
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function __construct(){
		//$this->init();
	}

	/**
	 * Инициализация, заполнение GroupMap группами прав (Group)  
	 *
	 * @useress private
	 * @return void
	 */
	/*private function init(){
		$app = Application::instance();
		$config = $app->getData("rules");
		$g_map = GroupMap::instance();
		foreach ($config->group as $group){
			$name = (string)$group["name"];
			$parent = (string)$group["parent"];
			
			if (!$parent) {
				$parent = null;
			}
			$obj = new Group($parent);
			$obj->setName($name);
			$obj->setParent($parent);
			
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

			$g_map->addRule($obj);
		}	
		
	}
	 */
	
	/**
	 * Получение прав на объект 
	 * 
	 * @param int $user_id 
	 * @param int $obj_id 
	 * @param string $obj_type 
	 * @useress public
	 * @return string
	 */
	public function getRuleObj($user_id, $obj_id, $obj_type){
		$factory= PersistenceFactory::getFactory('RuleObj');
		$finder= new DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject();
		$idobj->field('user_id')->eq($user_id);
		$idobj->field('object_name')->eq($obj_type);
		$idobj->field('object_id')->eq($obj_id);
		$rule = $finder->findOne($idobj, 'rule');
		if ($rule) {
			return $rule->getRule();
		}
		return NULL;
	}
	
	


	/**
	 * Получение статуса объекта 
	 * 
	 * @param int $obj_id 
	 * @param string $objType 
	 * @useress public
	 * @return string
	 */
	public function getObjStatus($obj_id, $objType){
		//тут запрос к VIEW на статус объекта
		$factory= PersistenceFactory::getFactory('StatusObj');
		$finder= new DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject()->field('object_id')->eq($obj_id)->field('object_type')->eq($objType);
		$status = $finder->findOne($idobj,'status');
		if ($status){
			return $status->getObj_Status();
		}
		return NULL;
		
	}


	public function getUserRoles($user_id){
		$factory= PersistenceFactory::getFactory('UserRole');
		$finder= new DomainObjectAssembler($factory);
		$idobj=$factory->getIndentityObject()->field('user_id')->eq($user_id);
		$user_roles = $finder->find($idobj,'roles');

		$roles = array();

		$roles[] = "USER";
		
		while ($user_roles->valid()){
			$role = $user_roles->current();
			$roles[] = $role->getRole();
			$user_roles->next();
		}	

		if ($roles){
			return $roles;
		}
		return NULL;
		
	}


	/**
	 * Проверка: разрешена ли команда данной группе 
	 * 
	 * @param string $cmd - сюда кладем название команды 
	 * @param Group $group - группа
	 * @param string $status - статус объекта
	 * @useress public
	 * @return boolean
	 */
	public function can($cmd, Group $group, $status = null){
		$allow = $group->isAllowed($cmd, $status);
		$deny = $group->isDenied($cmd, $status);
		$parent_group = $group->getParent();
		
		if (!$parent_group) {
			return ($allow)&&(!$deny);
		}

		if ($deny) {
			return false;
		}
		
		if ($allow) {
			return true;
		}
		
		return $this->can($cmd, $parent_group, $status);
	}
	
	/**
	 * Проверка: разрешена ли команда данному пользователю (залогиненному)  
	 * 
	 * @param Command $cmd 
	 * @useress public
	 * @return boolean
	 */
	public function check(Command $cmd){
		$g_map = GroupMap::instance();
		$session = new Session();
		$user = $session->get("user");

		$objType = NULL;
		$obj_id = NULL;
		$app = Application::instance();

		$cmd_name = get_class($cmd);
		$temp = explode("\\", $cmd_name);
		$cmd_name = end($temp);
		
		$command = $app->getCommandByClass($cmd_name);
		
		$objType = (string)$command["mainObj"];

		$roles = array();

		if($user) {
			$roles = $this->getUserRoles($user->getId());
		}
		else {				//получение ролей
			$roles[] = "GUEST";
		}


		if ($objType) {
			foreach ($command->param as $param) {
				if ($param["objId"]) {
					$param_name = (string)$param["name"];
					$obj_id = $cmd->getData($param_name);
				}
			}
			
			if ($user) {
				$obj_rule = $this->getRuleObj($user->getId(), $obj_id, $objType);
			}
			
			$status = $this->getObjStatus($obj_id, $objType);
			if (!$status) {
				$status = null;
			}
			if ($obj_rule) {
				return $this->can($cmd_name, $g_map->getRule($obj_rule), $status);
			}
		}

		foreach($roles as $g){
			$r = $this->can($cmd_name, $g_map->getRole($g));
			if($r){
				return $r;
			}
		}
		return false;
	}
	
}

?>
