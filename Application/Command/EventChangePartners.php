<?php

namespace Application\Command;

class EventChangePartners extends \System\Core\Command{
	public function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory("RuleObj");
		$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);
		$ruleobj_idobj = $factory_ruleobj->getIndentityObject();

		$ruleobj_idobj->field('obj_id')->eq($this->data["e_id"]);
		$ruleobj_idobj->field('obj_type')->eq(\System\Helper\Helper::getId("type", "event"));

		$rule = $ruleobj_finder->findOne($ruleobj_idobj, 'rule');

		switch ($this->req["do"]) {
			case 'add':
				foreach ($this->req["users"] as $user_id) {
					$ruleobj = new \Application\Model\RuleObj();

					$ruleobj->setUser_id($user_id);
					$ruleobj->setObj_id($this->data["e_id"]);
					$ruleobj->setRule("e_user");
					$ruleobj->setObj_type("event");

					$ruleobj_finder->insert($ruleobj);
				}
				break;

			case 'del':
				foreach ($this->req["users"] as $user_id) {
					$ruleobj_idobj = $factory_ruleobj->getIndentityObject();
					$ruleobj_idobj->field('user_userset_user_id')->eq($user_id);
					$ruleobj_idobj->field('user_userset_userset_id')->eq($rule->getUserset_id());

					$ruleobj_finder->delete($ruleobj_idobj, 'user_userset');
				}
				break;

			case 'ok':
				foreach ($this->req["users"] as $user_id) {
					$ruleobj = new \Application\Model\RuleObj();

					$ruleobj->setUser_id($user_id);
					$ruleobj->setObj_id($this->data["e_id"]);
					$ruleobj->setRule("e_partner");
					$ruleobj->setObj_type("event");

					$ruleobj_finder->insert($ruleobj);
				}
				break;
		}

		return $this->redirect($this->req["redirect"]);
	}
}
