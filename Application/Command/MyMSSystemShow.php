<?php

namespace Application\Command;

class MyMSSystemShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

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

		return $this->render(array("user" => $user, "messages" => $group->getMessages(), "personal_mess" => $personal_mess, "system_mess" => $system_mess));
	}
}