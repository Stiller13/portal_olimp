<?php

namespace Application\Command;

class MyMSPersonalGroupShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		$manager = \System\Msg\FactoryMGManager::getManager("personal");
		$group = $manager->getGroup($this->data['mg_id']);

		//Для добавления участников
		$factory_user = \System\Orm\PersistenceFactory::getFactory('User');
		$finder_user = new \System\Orm\DomainObjectAssembler($factory_user);
		$idobj = $factory_user->getIndentityObject();
		$user_list = $finder_user->find($idobj, 'user');

		//Количество непрочитанных
		$manager = \System\Msg\FactoryMGManager::getManager("personal");
		$list_group = $manager->getGroupsForUser($user->getId());

		$personal_mess = 0;
		foreach ($list_group as $one_group) {
			$personal_mess += $one_group->getVisit()->getCountMessage();
		}

		return $this->render(array("user" => $user, "group" => $group, "user_list" => $user_list, "personal_mess" => $personal_mess));
	}
}