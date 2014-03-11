<?php

namespace Application\Command;

class AdminMSNoticeGroupsShow extends \System\Core\Command{

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$manager = \System\Msg\FactoryMGManager::getManager("notice");
		$list_group = $manager->getAllGroups(array("status" => \System\Helper\Helper::getId("status", "all_user")));

		return $this->render(array("user" => $user, "list_group" => $list_group));
	}
}