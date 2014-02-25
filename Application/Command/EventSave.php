<?php

namespace Application\Command;
use Application\Model\Event;
use System\Orm\PersistenceFactory;
use System\Orm\DomainObjectAssembler;

class EventSave extends \System\Core\Command{
	public function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		if ($this->req["e_id"]) {
			$factory = PersistenceFactory::getFactory('Event');
			$finder = new DomainObjectAssembler($factory);
			$idobj = $factory->getIndentityObject();

			$idobj->field('event_id')->eq($this->req['e_id']);

			$event = $finder->findOne($idobj, 'event');
		}

		if ($event) {
			$event->setId($this->req["e_id"]);
			$event->setTitle($this->req["title"]);
			$event->setDescription_public($this->req["description_public"]);
			$event->setDescription_private($this->req["description_private"]);
			$event->setEvent_type($this->req["event_type"]);
			$event->setConfirm($this->req["confirm"]);
			$event->setConfirm_description($this->req["confirm_description"]);

			$finder->insert($event);

			return $this->redirect("/event/".$event->getId());
		} else {
			return $this->redirect("/event");
		}
	}
}
