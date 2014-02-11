<?php

namespace Application\Command;

class MSPersonalGroupAddUsers extends \System\Core\Command {

	protected function exec() {

		if ($this->req['secret_param'] === 'top_s_e_cret') {
			$factory_group = \System\Orm\PersistenceFactory::getFactory('PersonalMessageGroup');
			$finder_group = new \System\Orm\DomainObjectAssembler($factory_group);
			$idobj = $factory_group->getIndentityObject();

			$idobj->field('messagegroup_id')->eq($this->req['group_id']);

			$group = $finder_group->findOne($idobj, 'messagegroup');

			foreach ($this->req['users'] as $id_user) {
				$ruleobj = new \Application\Model\RuleObj();
				$ruleobj->setUser_id($id_user);
				$ruleobj->setObj_id($group->getUserset());
				$ruleobj->setRule(1);

				$factory_ruleobj = \System\Orm\PersistenceFactory::getFactory('RuleObj');
				$ruleobj_finder = new \System\Orm\DomainObjectAssembler($factory_ruleobj);
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