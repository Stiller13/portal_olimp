<?php

namespace Application\Command;

class MSPersonalGroupsShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		$manager = \System\Msg\FactoryMGManager::getManager("personal");
		$list_group = $manager->getGroupsForUser($user->getId());

		$personal_mess = 0;
		foreach ($list_group as $group) {
			$personal_mess += $group->getVisit()->getCountMessage();
		}

		return $this->render(array("user" => $user, "list_group" => $list_group, "personal_mess" => $personal_mess));
	}
}