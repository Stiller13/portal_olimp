<?php

namespace System\Msg;

/**
 * @author Zalutskii
 * @version 03.01.14
 * Класс-менеджер группы системных сообщений
 */

class SystemMGManager extends \System\Msg\MessageGroupManager {

	/**
	 * Получить группы по id пользователя-участника
	 * @return MessageGroupCollection
	 */
// 	public function getGroupsForUser($user_id) {
// 		$factory = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
// 		$finder = new \System\Orm\DomainObjectAssembler($factory);
// 		$idobj = $factory->getIndentityObject();

// 		$idobj->field("messagegroup_type")->eq(\System\Helper\Helper::getId("typegroup", "system"));
// 		$idobj->field("messagegroup_status")->eq(\System\Helper\Helper::getId("status", "open"));

// 		// $idobj->addWhat(array('message_group_id', 'message_group_title', 'message_group_description', 'message_group_partners', 'message_group_type', 'message_group_status'));
// 		// $idobj->addJoin('INNER',array('message_group','user_userset'),array('message_group_partners','userset_id'));
// 		// $idobj->field('message_group_type')->eq($this->type_group);
// 		// $idobj->field('user_id')->eq($user_id);
// 		// $idobj->field('message_group_status')->eq(5);
// 		// $idobj->changeLink();
// 		$main_list = $finder->find($idobj, "messagegroup");
// /*
// 		$factory2 = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
// 		$finder2 = new \System\Orm\DomainObjectAssembler($factory2);
// 		$idobj2 = $factory2->getIndentityObject();

// 		$idobj2->addWhat(array('message_group_id', 'message_group_title', 'message_group_description', 'message_group_partners', 'message_group_type', 'message_group_status'));
// 		$idobj2->addJoin('INNER',array('message_group','user_userset'),array('message_group_partners','userset_id'));
// 		$idobj2->field('message_group_type')->eq($this->type_group);
// 		$idobj2->field('message_group_status')->eq(5);

// 		$second_list = $finder2->find($idobj2, 'message_group');
// 		//супер код 0_o
// 		$i = 1;
// 		foreach ($second_list as $key => $value) {
// 			if ($i%2 === 0)
// 				$main_list->add($value);
// 			$i++;
// 		}*/

// 		// $main_list = new \Application\Orm\SystemMessageGroupCollection();

// 		// $main_list->add($open_group);

// 		return $main_list;
// 	}

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