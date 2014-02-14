<?php

namespace Application\Command;

class MSPersonalGroupCreate extends \System\Core\Command {

	protected function exec() {

		$session = new \System\Session\Session();
		$user = $session->get('user');

		$new_mg = new \Application\Model\PersonalMessageGroup();
		$new_mg->setStatus(1);

		$factory_group = \System\Orm\PersistenceFactory::getFactory('PersonalMessageGroup');
		$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
		$group_finder->insert($new_mg);

		$group_io = $factory_group->getIndentityObject();
		$group_io->field('messagegroup_id')->eq($new_mg->getId());
		$new_mg = $group_finder->findOne($group_io, 'messagegroup');

//Вставка в группу пользователей
		$ruleobj = new \Application\Model\RuleObj();

		$ruleobj->setUser_id($user->getId());
		$ruleobj->setObj_id($new_mg->getId());
		$ruleobj->setRule(1);
		$ruleobj->setObj_type(1);

		$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory('RuleObj');
		$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);
		$ruleobj_finder->insert($ruleobj);

//Вставка в visit-ов
		$visit = new \Application\Model\Visit();
		$visit->setMessageGroupId($new_mg->getId());
		$visit->setUserId($user->getId());

		$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
		$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);
		$visit_finder->insert($visit);

		return $this->redirect("/cabinet/message/personal/".$new_mg->getId());
	}
}