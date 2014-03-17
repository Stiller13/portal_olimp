<?php

namespace Application\Command;

class EventsShow extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user"); 

		$factory =\System\Orm\ PersistenceFactory::getFactory("Event");
		$finder = new \System\Orm\DomainObjectAssembler($factory);

		$idobj = $factory->getIndentityObject();

		if (!$user && $this->data["mode"]){
			if ($this->data["mode"] === 'my') {
				$this->data["mode"] = '';
			}
		}
		switch ($this->data["mode"]) {
			case 'my':
				$idobj->addWhat(array('event_id', 'event_title', 'event_description_public', 'event_description_private', 'event_type', 'event_confirm', 'event_confirm_description', 'event_status'));
				$idobj->addJoin('INNER',array('event','event_user'),array('event_id','event_user_event'));

				$idobj->field("event_user_user")->eq($user->getId());
				$idobj->field("event_user_rule")->eq(\System\Helper\Helper::getId("rule", "e_admin"));
				break;
			default:
				$idobj->field("event_status")->eq(\System\Helper\Helper::getId("status", "open"));
				break;
		}

		$events = $finder->find($idobj, "event");

		if ($user) {
			$factory = \System\Orm\PersistenceFactory::getFactory('UserRole');
			$finder = new \System\Orm\DomainObjectAssembler($factory);
			$idobj = $factory->getIndentityObject();

			$idobj->field('role_user')->eq($user->getId());
			$idobj->field('role_role')->eq(\System\Helper\Helper::getId("role", "MODERATOR"));

			$user_role = $finder->findOne($idobj,'role');

			if ($user_role) {
				$can_create = 1;
			}
		}

		return $this->render(array("user" => $user, "events" => $events, "can_create" => $can_create));
	}
}
