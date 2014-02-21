<?php

namespace Application\Command;
use Application\Model\Event;
use System\Orm\PersistenceFactory;
use System\Orm\DomainObjectAssembler;

class EventsShow extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get('user'); 

		$factory = PersistenceFactory::getFactory('Event');
		$finder = new DomainObjectAssembler($factory);

		$idobj = $factory->getIndentityObject();

		$events = $finder->find($idobj, 'event');

		$can_create = 1;//По так 

		return $this->render(array("user" => $user, "events" => $events, "can_create" => $can_create));
	}
}
