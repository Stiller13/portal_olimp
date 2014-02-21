<?php

namespace Application\Command;
use Application\Model\Event;
use System\Orm\PersistenceFactory;
use System\Orm\DomainObjectAssembler;

class EventSave extends \System\Core\Command{
	public function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$event = new Event();

		$event->setId($this->req["e_id"]);
		$event->setTitle($this->req["title"]);
		$event->setDescription_public($this->req["description_public"]);
		$event->setDescription_private($this->req["description_private"]);
		$event->setEvent_type($this->req["event_type"]);
		$event->setConfirm($this->req["confirm"]);
		$event->setConfirm_description($this->req["confirm_description"]);

		$factory = PersistenceFactory::getFactory('Event');
		$finder = new DomainObjectAssembler($factory);

		$finder->insert($event);

		if ($event->getId() > 0) {
			$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory('RuleObj');
			$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);

			$ruleobj = new \Application\Model\RuleObj();

			$ruleobj->setUser_id($user->getId());
			$ruleobj->setObj_id($event->getId());
			$ruleobj->setRule(\System\Helper\Helper::getId("rule", "e_admin"));
			$ruleobj->setObj_type(\System\Helper\Helper::getId("type", "event"));

			$ruleobj_finder->insert($ruleobj);

			return $this->redirect("/event/".$event->getId());
		} else {
			return $this->redirect("/event");
		}
	}
}
