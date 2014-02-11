<?php

namespace Application\Command;

class MSPersonalGroupsShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		$mg_type = 'personal';

		$manager = \System\Msg\FactoryMGManager::getManager($mg_type);
		$list_group = $manager->getGroupsForUser($user->getId());

		return $this->render(array("user" => $user, "list_group" => $list_group));
	}
}