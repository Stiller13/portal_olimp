<?php

namespace Application\Command;

class MyMSSystemShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		$type = \System\Helper\Helper::getId("type", "personal");
		$personal_mess = \System\Msg\VisitManager::getCountMess(array("for" => "type_group", "user_id" => $user->getId(), "group_type_id" => $type));

		$type = \System\Helper\Helper::getId("type", "system");
		$system_mess = \System\Msg\VisitManager::getCountMess(array("for" => "type_group", "user_id" => $user->getId(), "group_type_id" => $type));;

		$type = \System\Helper\Helper::getId("type", "notice");
		$notice_mess = \System\Msg\VisitManager::getCountMess(array("for" => "type_group", "user_id" => $user->getId(), "group_type_id" => $type));

		$manager = \System\Msg\FactoryMGManager::getManager("system");
		$list_system_group = $manager->getGroupsForUser($user->getId());

		$factory = \System\Orm\PersistenceFactory::getFactory('Message');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		foreach ($list_system_group as $group) {
			$idobj->field('message_group')->eq($group->getId());
		}

		if ($group) {
			$idobj->changeLink();
			$messages = $finder->find($idobj, 'message');
		} else {
			$messages = null;
		}

		return $this->render(array("user" => $user, "messages" => $messages, "personal_mess" => $personal_mess, "system_mess" => $system_mess, "notice_mess" => $notice_mess));
	}
}