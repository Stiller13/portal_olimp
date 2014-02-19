<?php

namespace Application\Command;

class MyMSSystemGroupShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		$manager = \System\Msg\FactoryMGManager::getManager("system");
		$group = $manager->getGroup($this->data['mg_id']);

		$manager = \System\Msg\FactoryMGManager::getManager("personal");
		$list_personal_group = $manager->getGroupsForUser($user->getId());

		$personal_mess = 0;
		foreach ($list_personal_group as $group) {
			$personal_mess += $group->getVisit()->getCountMessage();
		}

		$manager = \System\Msg\FactoryMGManager::getManager("system");
		$list_system_group = $manager->getGroupsForUser($user->getId());

		$system_mess = 0;
		foreach ($list_system_group as $group) {
			$system_mess += $group->getVisit()->getCountMessage();
		}

		return $this->render(array("user" => $user, "group" => $group, "personal_mess" => $personal_mess, "system_mess" => $system_mess));
	}
}