<?php

namespace System\Msg;

/**
 * @author Zalutskii
 * @version 03.01.14
 * Класс-менеджер группы системных сообщений
 */

class SystemMGManager extends \System\Msg\MessageGroupManager {

	public function getAllGroups() {
		$factory = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("messagegroup_type")->eq(\System\Helper\Helper::getId("typegroup", "system"));

		$list_group = $finder->find($idobj, "messagegroup");

		return $list_group;
	}

	public function Init() {
		$class_name = '\Application\Model\\'.$this->group_class_name;
		$new_mg = new $class_name();

		$new_mg->setStatus(0);
		$new_mg->setDescription("Для всех пользователей");

		$factory_group = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_finder->insert($new_mg);

		if ($new_mg->getId() > 0) {
			$factory_user = \System\Orm\PersistenceFactory::getFactory("User");
			$user_finder = new \System\Orm\DomainObjectAssembler($factory_user);
			$user_io = $factory_user->getIndentityObject();

			$user_list = $user_finder->find($user_io, "user");

			foreach ($user_list as $one_user) {
				$this->addUser($new_mg->getId(), $one_user->getId(), "smg_partner");
			}
		}
	}

}

?>