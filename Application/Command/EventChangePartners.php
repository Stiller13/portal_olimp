<?php

namespace Application\Command;

class EventChangePartners extends \System\Core\Command{
	public function exec() {

		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory = \System\Orm\PersistenceFactory::getFactory("Event");
		$finder = new \System\Orm\DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("event_id")->eq($this->data["e_id"]);

		$event = $finder->findOne($idobj, "event");

		$group_all_id = $event->getNoticeGroup('all')->getId();
		$group_users_id = $event->getNoticeGroup('users')->getId();
		$group_partners_id = $event->getNoticeGroup('partners')->getId();

		$mg_type = 'notice';
		$manager = \System\Msg\FactoryMGManager::getManager($mg_type);

		$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory("RuleObj");
		$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);
		$ruleobj_idobj = $factory_ruleobj->getIndentityObject();

		$ruleobj_idobj->field('obj_id')->eq($event->getId());
		$ruleobj_idobj->field('rule_id')->eq(\System\Helper\Helper::getId("rule", "e_admin"));
		$ruleobj_idobj->field('obj_type')->eq(\System\Helper\Helper::getId("type", "event"));

		$rule = $ruleobj_finder->findOne($ruleobj_idobj, 'rule');

		foreach ($this->req["users"] as $user_id) {
			if ($rule->getUser_id() === $user_id){
				continue;
			}
			switch ($this->req["do"]) {
				case 'add':
						$ruleobj = new \Application\Model\RuleObj();

						$ruleobj->setUser_id($user_id);
						$ruleobj->setObj_id($event->getId());
						$ruleobj->setRule("e_user");
						$ruleobj->setObj_type("event");

						$ruleobj_finder->insert($ruleobj);

						$manager->addUser($group_all_id, $user_id, "e_user");
						$manager->addUser($group_users_id, $user_id, "e_user");
					break;

				case 'del':
						$ruleobj_idobj = $factory_ruleobj->getIndentityObject();
						$ruleobj_idobj->field('user_userset_user_id')->eq($user_id);
						$ruleobj_idobj->field('user_userset_userset_id')->eq($rule->getUserset_id());

						$ruleobj_finder->delete($ruleobj_idobj, 'user_userset');

						$manager->delUser($group_all_id, $user_id);
						$manager->delUser($group_users_id, $user_id);
						$manager->delUser($group_partners_id, $user_id);
					break;

				case 'ok':
						$ruleobj = new \Application\Model\RuleObj();

						$ruleobj->setUser_id($user_id);
						$ruleobj->setObj_id($event->getId());
						$ruleobj->setRule("e_partner");
						$ruleobj->setObj_type("event");

						$ruleobj_finder->insert($ruleobj);

						$manager->delUser($group_users_id, $user_id);
						$manager->addUser($group_partners_id, $user_id, "e_user");
					break;
			}
		}

		return $this->redirect($this->req["redirect"]);
	}
}
