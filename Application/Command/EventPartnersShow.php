<?php

namespace Application\Command;
use Application\Model\Event;
use System\Orm\PersistenceFactory;
use System\Orm\DomainObjectAssembler;

class EventPartnersShow extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get("user");

		$factory = PersistenceFactory::getFactory("Event");
		$finder = new DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field("event_id")->eq($this->data["e_id"]);

		$event = $finder->findOne($idobj, "event");

/*		$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory("RuleObj");
		$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);
		$ruleobj_idobj = $factory_ruleobj->getIndentityObject();

		$ruleobj_idobj->field("obj_id")->eq($this->data["e_id"]);
		$ruleobj_idobj->field("obj_type")->eq(\System\Helper\Helper::getId("type", "event"));

		$rule = $ruleobj_finder->findOne($ruleobj_idobj, "rule");*/

		$factory_user = \System\Orm\PersistenceFactory::getFactory("User");
		$user_finder = new \System\Orm\DomainObjectAssembler($factory_user);
		/*$user_idobj = $factory_user->getIndentityObject();

		$user_idobj->addJoin("INNER", array("user", "user_userset"),array("user_id", "user_userset_user_id"));
		$user_idobj->field('user_userset_userset_id')->eq($rule->getUserset_id());
		$user_idobj->field('user_userset_rule_id')->eq(\System\Helper\Helper::getId("rule", "e_partner"));

		$partners = $user_finder->find($user_idobj, "user");

		$user_idobj = $factory_user->getIndentityObject();

		$user_idobj->addJoin("INNER", array("user", "user_userset"),array("user_id", "user_userset_user_id"));
		$user_idobj->field('user_userset_userset_id')->eq($rule->getUserset_id());
		$user_idobj->field('user_userset_rule_id')->eq(\System\Helper\Helper::getId("rule", "e_user"));

		$users = $user_finder->find($user_idobj, "user");*/

		//Для добавления участников
		$idobj = $factory_user->getIndentityObject();
		$idobj->addOrder(array('user_name'=>'ASC'));
		$user_list = $user_finder->find($idobj, 'user');

		return $this->render(array("user" => $user, "event" => $event, "rule" => "e_admin", "user_list" => $user_list));
	}
}