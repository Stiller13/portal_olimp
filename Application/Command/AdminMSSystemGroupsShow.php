<?php

namespace Application\Command;

class AdminMSSystemGroupsShow extends \System\Core\Command{

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$manager = \System\Msg\FactoryMGManager::getManager("system");
		$list_group = $manager->getAllGroups();

		$i = 0;
		foreach ($list_group as $value) {
			$i++;
		}
		if ($i === 0){
			$to_init = 1;
		}

		return $this->render(array("user" => $user, "list_group" => $list_group, "to_init" => $to_init));
	}
}