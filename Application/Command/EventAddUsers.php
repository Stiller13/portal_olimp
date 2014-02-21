<?php

namespace Application\Command;

class EventAddUsers extends \System\Core\Command{
	public function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");


		if ($event) {
			$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory('RuleObj');
			$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);

			$ruleobj = new \Application\Model\RuleObj();

			$ruleobj->setUser_id($user->getId());
			$ruleobj->setObj_id($event->getId());
			$ruleobj->setRule(\System\Helper\Helper::getId("rule", "e_admin"));
			$ruleobj->setObj_type(\System\Helper\Helper::getId("type", "event"));

			$ruleobj_finder->insert($ruleobj);

			return $this->redirect("/event/".$event->getId());
		}
	}
}
