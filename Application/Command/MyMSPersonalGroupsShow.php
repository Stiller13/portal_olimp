<?php

namespace Application\Command;

class MyMSPersonalGroupsShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		$manager = \System\Msg\FactoryMGManager::getManager("personal");
		$list_personal_group = $manager->getGroupsForUser($user->getId());

		$type = \System\Helper\Helper::getId("type", "personal");
		$personal_mess = \System\Msg\VisitManager::getCountMess(array("for" => "type_group", "user_id" => $user->getId(), "group_type_id" => $type));

		$type = \System\Helper\Helper::getId("type", "system");
		$system_mess = \System\Msg\VisitManager::getCountMess(array("for" => "type_group", "user_id" => $user->getId(), "group_type_id" => $type));;

		$type = \System\Helper\Helper::getId("type", "notice");
		$notice_mess = \System\Msg\VisitManager::getCountMess(array("for" => "type_group", "user_id" => $user->getId(), "group_type_id" => $type));

		return $this->render(array("user" => $user, "list_group" => $list_personal_group, "personal_mess" => $personal_mess, "system_mess" => $system_mess, "notice_mess" => $notice_mess));
	}
}