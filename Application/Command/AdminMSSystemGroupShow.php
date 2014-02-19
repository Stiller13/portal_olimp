<?php

namespace Application\Command;

class AdminMSSystemGroupShow extends \System\Core\Command{

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$manager = \System\Msg\FactoryMGManager::getManager("system");
		$group = $manager->getGroup($this->data["mg_id"]);
		$list_group = $manager->getAllGroups();

		return $this->render(array("user" => $user, "list_group" => $list_group, "group" => $group));
	}
}
