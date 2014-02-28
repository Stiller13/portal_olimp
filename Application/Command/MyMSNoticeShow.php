<?php

namespace Application\Command;

class MyMSNoticeShow extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		$manager = \System\Msg\FactoryMGManager::getManager("personal");
		$list_personal_group = $manager->getGroupsForUser($user->getId());

		$personal_mess = 0;
		foreach ($list_personal_group as $pgroup) {
			$personal_mess += $pgroup->getVisit()->getCountMessage();
		}

		$manager = \System\Msg\FactoryMGManager::getManager("notice");
		$list_system_group = $manager->getGroupsForUser($user->getId());

		$factory = \System\Orm\PersistenceFactory::getFactory('Message');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$system_mess = 0;
		foreach ($list_system_group as $group) {
			$system_mess += $group->getVisit()->getCountMessage();
			$idobj->field('message_group')->eq($group->getId());
		}

		if ($group) {
			$idobj->changeLink();
			$messages = $finder->find($idobj, 'message');
		} else {
			$messages = null;
		}

		return $this->render(array("user" => $user, "messages" => $messages, "personal_mess" => $personal_mess, "system_mess" => $system_mess));
	}
}