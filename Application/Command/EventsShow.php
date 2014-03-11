<?php

namespace Application\Command;

class EventsShow extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user"); 

		$factory =\System\Orm\ PersistenceFactory::getFactory("Event");
		$finder = new \System\Orm\DomainObjectAssembler($factory);

		$idobj = $factory->getIndentityObject();

		switch ($this->data["mode"]) {
			case 'my':
				$factory_user =\System\Orm\ PersistenceFactory::getFactory("EUser");
				$finder_user = new \System\Orm\DomainObjectAssembler($factory_user);
				$idobj_user = $factory_user->getIndentityObject();

				$idobj_user->field("event_user_user")->eq($user->getId());
				$idobj_user->field("event_user_rule")->eq(\System\Helper\Helper::getId("rule", "e_admin"));

				$euser = $finder_user->findOne($idobj_user, "event_user");

				$idobj->field("event_id")->eq($euser?$euser->getEvent():0);
				break;
			default:
				$idobj->field("event_status")->eq(\System\Helper\Helper::getId("status", "open"));
				break;
		}

		$events = $finder->find($idobj, "event");

		$factory = \System\Orm\PersistenceFactory::getFactory('UserRole');
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('role_user')->eq($user->getId());
		$idobj->field('role_role')->eq(\System\Helper\Helper::getId("role", "MODERATOR"));

		$user_role = $finder->findOne($idobj,'role');

		if ($user_role) {
			$can_create = 1;
		}

		return $this->render(array("user" => $user, "events" => $events, "can_create" => $can_create));
	}
}
