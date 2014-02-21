<?php

namespace Application\Command;

class EventAddUsers extends \System\Core\Command{
	public function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory("RuleObj");
		$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);

		foreach ($this->req["users"] as $value) {
			$ruleobj = new \Application\Model\RuleObj();

			$ruleobj->setUser_id($value);
			$ruleobj->setObj_id($this->data["e_id"]);
			$ruleobj->setRule(\System\Helper\Helper::getId("rule", "e_user"));
			$ruleobj->setObj_type(\System\Helper\Helper::getId("type", "event"));

			$ruleobj_finder->insert($ruleobj);
		}

		return $this->redirect("/event/".$this->data["e_id"]);
	}
}
