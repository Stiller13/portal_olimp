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
	public function getGroupsForUser($user_id) {
		$factory = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->addWhat(array('message_group_id', 'message_group_title', 'message_group_description', 'message_group_partners', 'message_group_type', 'message_group_status'));
		$idobj->addJoin('INNER',array('message_group','user_userset'),array('message_group_partners','userset_id'));
		$idobj->field('message_group_type')->eq($this->type_group);
		$idobj->field('user_id')->eq($user_id);
		// $idobj->field('message_group_status')->eq(5);
		// $idobj->changeLink();
		$main_list = $finder->find($idobj, 'message_group');

		$factory2 = \System\Orm\PersistenceFactory::getFactory($this->group_class_name);
		$finder2 = new \System\Orm\DomainObjectAssembler($factory2);
		$idobj2 = $factory2->getIndentityObject();

		$idobj2->addWhat(array('message_group_id', 'message_group_title', 'message_group_description', 'message_group_partners', 'message_group_type', 'message_group_status'));
		$idobj2->addJoin('INNER',array('message_group','user_userset'),array('message_group_partners','userset_id'));
		$idobj2->field('message_group_type')->eq($this->type_group);
		$idobj2->field('message_group_status')->eq(5);

		$second_list = $finder2->find($idobj2, 'message_group');
		//супер код 0_o
		$i = 1;
		foreach ($second_list as $key => $value) {
			if ($i%2 === 0)
				$main_list->add($value);
			$i++;
		}

		return $main_list;
	}

}

?>