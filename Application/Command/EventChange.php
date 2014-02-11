<?php

namespace Application\Command;
use Application\Model\Event;
use System\Orm\PersistenceFactory;
use System\Orm\DomainObjectAssembler;

class EventChange extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get('user');		
		
		$factory = PersistenceFactory::getFactory('Event');
		$finder = new DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();
		$idobj->field('event_id')->eq($this->data['e_id']);
		$event = $finder->findOne($idobj, 'event');
 
		// просто показывает форму для внесения превоначальных настроек
		
		return $this->render(array("user" => $user, "event" => $event));
	}
}

