<?php

namespace Application\Command;
use Application\Model\Event;
use System\Orm\PersistenceFactory;
use System\Orm\DomainObjectAssembler;

class EventShow extends \System\Core\Command {

	protected function exec() {
		$session = new \System\Session\Session();
		$user = $session->get('user'); 

		$factory = PersistenceFactory::getFactory('Event');
		$finder = new DomainObjectAssembler($factory);
		$idobj = $factory->getIndentityObject();

		$idobj->field('event_id')->eq($this->data['e_id']);

		$event = $finder->findOne($idobj, 'event');

		$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory('RuleObj');
		$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);
		$ruleobj_idobj = $factory_ruleobj->getIndentityObject();

		$ruleobj_idobj->field('obj_id')->eq($this->data['e_id']);
		$ruleobj_idobj->field('user_id')->eq($user->getId());
		$ruleobj_idobj->field('obj_type')->eq(\System\Helper\Helper::getId("type", "event"));

		$rule = $ruleobj_finder->findOne($ruleobj_idobj, 'rule');

		if ($rule){
			$rule = \System\Helper\Helper::getName("rule", $rule->getRule());
		} else
			$rule = null;

		return $this->render(array("event" => $event, "user" => $user, "rule" => $rule));
	}
}
