<?php

namespace Application\Command;

class MSPersonalGroupAddUsers extends \System\Core\Command {

	protected function exec() {

		if ($this->req['secret_param'] === 'top_s_e_cret') {
			$factory_group = \System\Orm\PersistenceFactory::getFactory('PersonalMessageGroup');
			$group_finder = new \System\Orm\DomainObjectAssembler($factory_group);
			$group_io = $factory_group->getIndentityObject();
			$group_io->field('messagegroup_id')->eq($this->req['group_id']);
			$mg = $group_finder->findOne($group_io, 'messagegroup');

			$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory('RuleObj');
			$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);

			foreach ($this->req['users'] as $id_user) {
				$rule_io = $factory_ruleobj->getIndentityObject();
				$rule_io->field('user_userset_user_id')->eq($id_user);
				$rule_io->field('user_userset_userset_id')->eq($mg->getUserset());

				$rule = $ruleobj_finder->findOne($rule_io, 'user_userset');
				if ($rule)
					continue;

				$ruleobj = new \Application\Model\RuleObj();
				$ruleobj->setUser_id($id_user);
				$ruleobj->setUserset_id($mg->getUserset());
				$ruleobj->setRule(1);

				$ruleobj_finder->insert($ruleobj);

				$visit = new \Application\Model\Visit();
				$visit->setMessageGroupId($this->req['group_id']);
				$visit->setUserId($id_user);

				$factory_visit = \System\Orm\PersistenceFactory::getFactory('Visit');
				$visit_finder = new \System\Orm\DomainObjectAssembler($factory_visit);
				$visit_finder->insert($visit);
			}
		}

		return $this->redirect("/cabinet/message/personal/".$this->req['group_id']);
	}

}