<?php

namespace Application\Command;

class EventMessageShow extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory = \System\Orm\PersistenceFactory::getFactory("Event");
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("event_id")->eq($this->data["e_id"]);

		$event = $finder->findOne($idobj, "event");

/*		$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory("RuleObj");
		$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);
		$ruleobj_idobj = $factory_ruleobj->getIndentityObject();

		$ruleobj_idobj->field("obj_id")->eq($this->data["e_id"]);
		$ruleobj_idobj->field("obj_type")->eq(\System\Helper\Helper::getId("type", "event"));

		$rule = $ruleobj_finder->findOne($ruleobj_idobj, "rule");*/

		switch ($this->data['mode']) {
			case 'partners':
				$mode = 'partners';
				break;
			case 'users':
				$mode = 'users';
				break;
			default:
				$mode = 'all';
				break;
		}

		return $this->render(array("user" => $user, "event" => $event, "rule" => "e_admin", "mode" => $mode));
	}
}