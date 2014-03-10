<?php

namespace Application\Command;

class NewsShowAll extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user"); 

		// $factory =\System\Orm\ PersistenceFactory::getFactory("EUser");
		// $finder = new \System\Orm\DomainObjectAssembler($factory);
		// $idobj = $factory->getIndentityObject();

		// $idobj->field("event_user_user")->eq($user->getId());
		// $idobj->field("event_user_rule")->eq(\System\Helper\Helper::getId("rule", "e_admin"));

		// $list_euser = $finder->find($idobj, "event_user");

		// $factory =\System\Orm\ PersistenceFactory::getFactory("Event");
		// $finder = new \System\Orm\DomainObjectAssembler($factory);

		// $idobj = $factory->getIndentityObject();
		// $idobj->field("event_status")->eq(\System\Helper\Helper::getId("status", "open"));

		// foreach ($list_euser as $one_euser) {
		// 	$idobj->field("event_id")->eq($one_euser->getEvent());
		// }
		// $idobj->changeLink();

		// $events = $finder->find($idobj, "event");

		// $can_create = 1;//Пока так(На создание пероприятия)

		return $this->render(array("user" => $user, "can_create" => $can_create));
	}
}
